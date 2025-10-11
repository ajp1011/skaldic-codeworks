<?php

declare(strict_types=1);

namespace Tests;

use Illuminate\Foundation\Testing\{RefreshDatabase, TestCase as BaseTestCase};
use Illuminate\Support\Facades\DB;

abstract class TestCase extends BaseTestCase
{
    /**
     * Setup the test case.
     * This runs BEFORE parent::setUp() to check database availability early.
     *
     * @return void
     */
    protected function setUp(): void
    {
        // Check database availability before Laravel tries to connect
        $this->checkDatabaseBeforeSetup();

        parent::setUp();
    }

    /**
     * Check database connection before setup if test requires it.
     * This allows unit tests to run locally without Docker/database.
     *
     * @return void
     */
    protected function checkDatabaseBeforeSetup(): void
    {
        // Check if this test uses RefreshDatabase trait (indicator of feature test)
        $usesRefreshDatabase = in_array(
            RefreshDatabase::class,
            array_keys(class_uses_recursive($this))
        );

        // If test uses RefreshDatabase, check for DB connection BEFORE Laravel tries
        if ($usesRefreshDatabase) {
            // Check if we can connect to the database
            if (!$this->isDatabaseAvailable()) {
                $this->markTestSkipped(
                    'Database connection not available. Feature tests require database. ' .
                    'Run in Docker: docker exec skaldic-codeworks-app php artisan test'
                );
            }
        }
    }

    /**
     * Check if database connection is available.
     *
     * @return bool
     */
    protected function isDatabaseAvailable(): bool
    {
        try {
            // Get database driver from environment (before Laravel boots)
            $driver = $_ENV['DB_CONNECTION'] ?? 'mysql';

            // For SQLite, check if we have the PDO driver
            if ($driver === 'sqlite') {
                return extension_loaded('pdo_sqlite');
            }

            // For MySQL/PostgreSQL, try to connect
            if ($driver === 'mysql' || $driver === 'pgsql') {
                $host = $_ENV['DB_HOST'] ?? 'localhost';
                $port = $_ENV['DB_PORT'] ?? ($driver === 'mysql' ? '3306' : '5432');
                $database = $_ENV['DB_DATABASE'] ?? 'laravel';
                $username = $_ENV['DB_USERNAME'] ?? 'root';
                $password = $_ENV['DB_PASSWORD'] ?? '';

                $dsn = "{$driver}:host={$host};port={$port};dbname={$database}";
                $pdo = new \PDO($dsn, $username, $password, [
                    \PDO::ATTR_TIMEOUT => 2,
                    \PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION,
                ]);
                $pdo = null; // Close connection

                return true;
            }

            return false;
        } catch (\Exception $e) {
            return false;
        }
    }
}
