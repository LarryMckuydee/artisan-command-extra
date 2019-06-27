<?php

namespace ArtisanCommandExtra\Console\Migrations;

use Illuminate\Console\Command;
use Doctrine\DBAL\DriverManager;
use Doctrine\DBAL\Configuration;
use Doctrine\DBAL\Exception\DriverException;
//Migration database create command

class CreateCommand extends Command {

    /**
     * @var string The artisan command name.
     */
     protected $name = 'db:create';

    /**
     * @var string The artisan command description
     */
     protected $description = 'Create a new database if not existed';

    /**
     * @var string The artisan command signature
     */
     protected $signature = 'db:create';

    /**
     * Array to store connection parameters
     * @var array 
     */
    private $connectionParams = array();

    /**
     *@var DriverManager::getConnection instance or null when not connected
     */
    private $conn;

    /**
     * @var Configuration instance or null when not configured
     */
    private $config;

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        $this->createDatabase();
    }

    public function createDatabase()
    {
        //get database configuration params from env

        $driver   = env('DB_CONNECTION', false);
        $user     = env('DB_USERNAME', false);
        $password = env('DB_PASSWORD', false);
        $database = env('DB_DATABASE', false);
        $host     = env('DB_HOST', false);
        $port     = env('DB_PORT', false);

        $this->connectionParams = array(
            'driver'    => $this->getDriver($driver),
            'user'      => $user,
            'password'  => $password,
            'host'      => $host
        );
        $this->getConnection();    
        
        $sql = 'CREATE DATABASE '.$database;
        try {
            $statement = $this->conn->query($sql);
            $this->info(sprintf('Successfully created database'));
        } catch (DriverException $e) {
            $this->error(sprintf('Failed to created database, because of error:'. $e->getMessage()));
        }
    } 

    /**
     * Get compatible alias for Doctrine configuration
     * @param string $connectionString
     * 
     * @return string
     */
    public function getDriver($connectionString)
    {
        $driver = array (
            'db2'       =>'ibm_db2',
            'mssql'     =>'pdo_sqlsrv',
            'mysql'     =>'pdo_mysql',
            'mysql2'    =>'pdo_mysql',
            'pgsql'     =>'pdo_pgsql',
            'postgres'  =>'pdo_pgsql',
            'postgresql'=>'pdo_pgsql',
            'sqlite'    =>'pdo_sqlite',
            'sqlite3'   =>'pdo_sqlite',
        );
        
        if (isset($driver[$connectionString])) {
            return $driver[$connectionString];
        } else {
            $this->error(sprintf('Driver not found for: '.$connectionString));
        }
    }

    /**
     * Connection establish here
     *
     * @return Connection
     */

    public function getConnection()
    {
        $this->config = new Configuration();
        $this->conn = DriverManager::getConnection($this->connectionParams,$this->config);
    }


}

?>
