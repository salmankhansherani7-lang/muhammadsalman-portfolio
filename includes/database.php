<?php
/**
 * Database Handler
 * Muhammad Salman - AI Engineer Portfolio
 * Supports SQLite (auto-provisioned out of the box) and MySQL
 */

defined('SECURE_ACCESS') or die('Direct access forbidden.');

require_once __DIR__ . '/config.php';

class DB {
    private static ?PDO $instance = null;

    public static function conn(): PDO {
        if (self::$instance !== null) {
            return self::$instance;
        }

        try {
            if (DB_DRIVER === 'mysql') {
                $dsn = sprintf('mysql:host=%s;port=%s;dbname=%s;charset=%s', DB_HOST, DB_PORT, DB_NAME, DB_CHARSET);
                self::$instance = new PDO($dsn, DB_USER, DB_PASS, [
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                    PDO::ATTR_EMULATE_PREPARES => false,
                ]);
            } else {
                // SQLite connection
                $dbDir = dirname(SQLITE_FILE);
                if (!is_dir($dbDir)) {
                    mkdir($dbDir, 0755, true);
                }

                $isNewDb = !file_exists(SQLITE_FILE) || filesize(SQLITE_FILE) === 0;

                self::$instance = new PDO('sqlite:' . SQLITE_FILE, null, null, [
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                ]);

                // Enable foreign keys in SQLite
                self::$instance->exec('PRAGMA foreign_keys = ON;');

                // Automatically provision schema & seed if new database
                if ($isNewDb) {
                    self::initializeDatabase(self::$instance);
                }
            }

            return self::$instance;
        } catch (PDOException $e) {
            if (APP_ENV === 'development') {
                die('Database Connection Error: ' . htmlspecialchars($e->getMessage()));
            } else {
                die('A database connection error occurred. Please verify your configuration.');
            }
        }
    }

    /**
     * Automatically execute schema.sql and seed.sql on first run for SQLite
     */
    private static function initializeDatabase(PDO $pdo): void {
        $schemaFile = DB_PATH . '/schema.sql';
        $seedFile = DB_PATH . '/seed.sql';

        if (file_exists($schemaFile)) {
            $schemaSql = file_get_contents($schemaFile);
            $pdo->exec($schemaSql);
        }

        if (file_exists($seedFile)) {
            $seedSql = file_get_contents($seedFile);
            $pdo->exec($seedSql);
        }
    }

    /**
     * Execute a SELECT query and fetch all matching records
     */
    public static function fetchAll(string $sql, array $params = []): array {
        $stmt = self::conn()->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll();
    }

    /**
     * Execute a SELECT query and fetch a single matching record
     */
    public static function fetchOne(string $sql, array $params = []): ?array {
        $stmt = self::conn()->prepare($sql);
        $stmt->execute($params);
        $res = $stmt->fetch();
        return $res !== false ? $res : null;
    }

    /**
     * Execute an INSERT, UPDATE, or DELETE query and return affected rows
     */
    public static function execute(string $sql, array $params = []): int {
        $stmt = self::conn()->prepare($sql);
        $stmt->execute($params);
        return $stmt->rowCount();
    }

    /**
     * Return the last inserted ID
     */
    public static function lastInsertId(): string {
        return self::conn()->lastInsertId();
    }
}

