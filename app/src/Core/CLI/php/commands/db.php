<?php
/**
 * Perform database operations.
 *
 * ## EXAMPLES
 *
 *     # Create a mysqldump of eduTrac SIS.
 *     $ ./etsis db backup
 *     Success: Database export is complete.
 * 
 *     $ ./etsis db optimize
 *     Success: Database optimization complete. 
 *
 *     $ ./etsis db tables
 *     Success: Database table list complete. 
 * 
 */
ETSIS_CLI::add_command('db', 'Db_Command');

class Db_Command extends ETSIS_CLI_Command
{

    private $pdo;
    private $db;

    /**
     * Creates a connection to the system's database and performs a mysqldump.
     * 
     * ## EXAMPLES
     *  
     *     $ ./etsis db backup
     *     Success: Database export is complete.
     * 
     * ## OPTIONS
     * 
     * [--dir=<path>]
     * : Where the mysqldump should be saved. If empty, saved in root. 
     *  
     *     $ ./etsis db backup --dir=app/tmp
     *     Success: Database export is complete.  
     */
    public function backup()
    {
        if (defined('ETSIS_DIR')) {
            $filename = ETSIS_DIR . '/' . date("Y-m-d") . strtotime(date('h:m:s')) . '_etsis-backup.sql';
        } else {
            $filename = date("Y-m-d") . strtotime(date('h:m:s')) . '_etsis-backup.sql';
        }

        try {
            ETSIS_CLI::line('Starting export process...');
            $this->db = new Mysqldump('mysql:host=' . DB_HOST . ';dbname=' . DB_NAME, DB_USER, DB_PASS);
            ETSIS_CLI::line(sprintf('Writing to file "%s"', $filename));
            $this->db->start($filename);
            ETSIS_CLI::success('Database export is complete.');
        } catch (\Exception $e) {
            ETSIS_CLI::error(sprintf('The database backup "%s" was not successfull. Here is the error given: "%s"', $filename, $e->getMessage()));
        }
    }

    /**
     * Optimize eduTrac SIS Database.
     * 
     * ## EXAMPLES
     *  
     *     $ ./etsis db optimize
     *     Success: Database optimization complete.  
     */
    public function optimize()
    {
        try {
            $this->pdo = new PDO('mysql:host=' . DB_HOST . ';dbname=' . DB_NAME, DB_USER, DB_PASS, [PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"]);
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->pdo->query('SET CHARACTER SET utf8');
        } catch (PDOException $e) {
            echo 'ERROR: ' . $e->getMessage();
        }

        ETSIS_CLI::line('Starting optimization process...');
        $opt = $this->pdo->query("SHOW TABLES");

        foreach ($opt as $r) {
            opt_notify(new \cli\progress\Bar('  %GTable:%n ' . $r['Tables_in_' . DB_NAME], 1000000));
            $this->pdo->query('OPTIMIZE TABLE ' . $r['Tables_in_' . DB_NAME]);
        }
        $this->pdo = null;
        ETSIS_CLI::success('Database optimization complete.');
    }

    /**
     * List all the tables in eduTrac SIS database.
     * 
     * ## EXAMPLES
     *  
     *     $ ./etsis db tables
     *     Success: Database table list complete. 
     */
    public function tables()
    {
        try {
            $this->pdo = new PDO('mysql:host=' . DB_HOST . ';dbname=' . DB_NAME, DB_USER, DB_PASS, [PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"]);
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->pdo->query('SET CHARACTER SET utf8');
        } catch (PDOException $e) {
            echo 'ERROR: ' . $e->getMessage();
        }

        $opt = $this->pdo->query("SHOW TABLES");

        foreach ($opt as $r) {
            ETSIS_CLI::line(' %GTable:%n ' . $r['Tables_in_' . DB_NAME]);
        }
        $this->pdo = null;
        ETSIS_CLI::success('Database table list complete.');
    }
}