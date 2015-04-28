<?php
/**
 * DatabaseClass
 */
class Database {
    
    private $_conn;


    /**
     * Creates database connection
     * @param Version $version
     */
    public function __construct() {
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
    
    private function _getRowCount($tableName) {
        if ( $rs = $this->_conn->query('SELECT COUNT(*) FROM '.$tableName) ) {
            $r = $rs->fetch_array();
            $rs->free();
            return $r[0];
    }
        return NULL;
    }
    
    public function importFile($fileName, $tableName)
    {
        $oldRowCount = $this->_getRowCount($tableName);
        echo "oldRowCount: $oldRowCount<br>";
        
        //$fileName = str_replace('\\', '\\\\', $fileName);
        
        $sql = "LOAD DATA LOCAL INFILE '".$fileName."'
                INTO TABLE ".$tableName."
                FIELDS TERMINATED BY ';'
                LINES TERMINATED BY '\\n'";
        
        echo $sql;
        
        $result = mysqli_query($this->_conn, $sql);

        if (mysqli_affected_rows($this->_conn) == 1) {
          $message = "The data was successfully added!";
        } else {
          $message = "The user update failed: ";
          $message .= mysqli_error($this->_conn); 
        }
        
        echo $message;
    }
}
