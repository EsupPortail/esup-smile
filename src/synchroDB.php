<?php
require_once 'vendor/autoload.php';




$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

$dbHost = $_ENV['DB_HOST'];
$dbPort = $_ENV['DB_PORT'];
$dbName = $_ENV['DB_NAME'];
$dbUser = $_ENV['DB_USER'];
$dbPassword = $_ENV['DB_PSWD'];

$synchroDb = new SynchroDatabase();
$synchroDb->connect($dbHost, $dbName, $dbUser, $dbPassword);
$synchroDb->createDatabaseToCompare($dbHost, $dbName."compare", $dbUser, $dbPassword);
$synchroDb->getDiff();

class SynchroDatabase {
    private $pdo;
    private $pdoCompare;

    public function connect($dbHost, $dbName, $dbUser, $dbPassword) {
        try {
            echo "Connecting to database...\n";
            $pdo = new PDO("pgsql:host=$dbHost;dbname=$dbName", $dbUser, $dbPassword);
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $pdo->setAttribute(PDO::ATTR_CASE, PDO::CASE_NATURAL);
            $this->pdo = $pdo;
            echo "Connected successfully\n";
        } catch(PDOException $e) {
            echo "Connection failed: " . $e->getMessage()."\n";
        }
    }

    public function getDiff() {
        $tableNames = $this->getTableNames();
        foreach($tableNames as $tableName) {
//            $this->getDiffForTable($tableName);
        }
    }

    public function getDiffForTable($tableName): void
    {
        try {
            // Get the schema of the table from the first database
            $stmt = $this->pdo->query(
                "SELECT column_name, data_type, character_maximum_length
                                   FROM INFORMATION_SCHEMA.COLUMNS WHERE table_name = '$tableName'"
            );
            $table1 = $stmt->fetchAll(PDO::FETCH_ASSOC);

            // Get the schema of the table from the second database
            $stmt = $this->pdoCompare->query(
                "SELECT column_name, data_type, character_maximum_length
                                          FROM INFORMATION_SCHEMA.COLUMNS WHERE table_name = '$tableName'"
            );
            $table2 = $stmt->fetchAll(PDO::FETCH_ASSOC);

            // Compare the two schemas
            $diff = array_diff_assoc($table1, $table2);

            if (!empty($diff)) {
                echo "Differences found in table $tableName: \n";
                print_r($diff);
            } else {
                echo "No differences found in table $tableName.\n";
            }
        } catch (PDOException $e) {
            echo "Failed to retrieve schema for table $tableName: "
                . $e->getMessage() . "\n";
        }
    }

    public function createDatabaseToCompare($dbHost, $dbName, $dbUser, $dbPassword) {
        try {
            echo "Creating synchro database...\n";
            $dbNames = $this->getDatabaseNames();
            if(in_array($dbName, $dbNames)) {
                echo "Database already exists\n";
            }else{
                $this->pdo->exec("CREATE DATABASE $dbName;");
            }
            $pdo = new PDO("pgsql:host=$dbHost;dbname=$dbName", $dbUser, $dbPassword);
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->pdoCompare = $pdo;

            $this->importDBFromSQL();

            echo "Synchro database connected successfully\n";
        } catch(PDOException $e) {
            echo "Database creation failed: " . $e->getMessage()."\n";
        }
    }

    public function importDBFromSQL() {
        try {
            // Get all SQL files in the /smile-database folder
            $sqlFiles = glob('/smile-database/*.sql');

            // Sort the files to ensure they are processed in order
            sort($sqlFiles);
            // Loop through the files
            foreach ($sqlFiles as $sqlFile) {
                echo "Executing SQL file: $sqlFile...\n";
                // Read the file contents into a string
                $sqlCommands = file_get_contents($sqlFile);
                // Execute the SQL commands
//                $this->pdoCompare->exec($sqlCommands);
            }

            echo "All SQL files have been executed successfully.\n";
        } catch(PDOException $e) {
            echo "Failed to execute SQL files: " . $e->getMessage()."\n";
        }
    }

    public function getDatabaseNames() {
        try {
            $stmt = $this->pdoCompare->query("SELECT datname FROM pg_database;");
            $databaseNames = $stmt->fetchAll(PDO::FETCH_COLUMN);
            return $databaseNames;
        } catch(PDOException $e) {
            echo "Failed to retrieve database names: " . $e->getMessage()."\n";
        }
    }
    public function getTableNames() {
        $stmt = $this->pdo->query("SELECT table_name FROM information_schema.tables WHERE table_schema='public' AND table_type='BASE TABLE'");
        $tableNames = $stmt->fetchAll(PDO::FETCH_COLUMN);
        return $tableNames;
    }
}
