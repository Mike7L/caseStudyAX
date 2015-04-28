<?php
/**
 * DatabaseClass for all database operations
 */
class Database {
    
    /**
     * @var database connection 
     */
    private $_conn;

    /**
     * Creates database connection
     * @param Version $version
     */
    public function __construct() {
        
        var_dump(Config::getInstance()->settings);
        $this->_conn=mysqli_connect(
                            Config::getInstance()->settings['database']['host'],
                            Config::getInstance()->settings['database']['username'],
                            Config::getInstance()->settings['database']['password'],
                            Config::getInstance()->settings['database']['dbname']
                            );
        // Check connection
        if (mysqli_connect_errno()) {
            throw new Exception("Failed to connect to MySQL: " . mysqli_connect_error());
        }
    }
    
    /**
     * Gests row count in given table
     * @param string $tableName
     * @return int
     */
    private function _getRowCount($tableName) {
        if ( $rs = $this->_conn->query('SELECT COUNT(*) FROM '.$tableName) ) {
            $r = $rs->fetch_array();
            return $r[0];
    }
        return NULL;
    }
    
    /**
     * Truncates given table
     * @param string $tableName
     */
    private function _truncateTable($tableName) {
        $this->_conn->query('TRUNCATE '.$tableName);
    }
    
    /**
     * Imports temporary file $fileName into table $tableName
     * @param string $fileName
     * @param string $tableName
     */
    public function importFile($fileName, $tableName)
    {
        $oldRowCount = $this->_getRowCount($tableName);
        $this->_truncateTable($tableName);
        
        $sql = "LOAD DATA INFILE '".str_replace('\\', '/', $fileName)."'
                INTO TABLE ".$tableName."
                FIELDS TERMINATED BY ';'
                LINES TERMINATED BY '\\n'";
        
        mysqli_query($this->_conn, $sql);
        $newRowCount = mysqli_affected_rows($this->_conn);
        
        //We become all data every tyme, so
        //the differences are actually new records
        Logger::getInstance()->reportInsert($newRowCount - $oldRowCount);
        Logger::getInstance()->reportUpdate($oldRowCount);
    }
    
    public function writeProtocol() {
        $stats = Logger::getInstance()->getStats();
        
        $sql = "INSERT INTO protokoll (startTime, endTime, inserts, updates, errors) ".
                "VALUES (\"".$stats['start']."\",NOW(),".$stats['inserts'].",".
                $stats['updates'].",".$stats['errors'].")";
        mysqli_query($this->_conn, $sql);
    }
}
