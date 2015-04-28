<?php
require_once 'Converter.php';

/**
 * Checks the file for errors and parses it depending on schema
 *
 */
class Parser {

    /**
     * schema of the parser
     * @var array 
     */
    private $_schema = '';
    
    /**
     * Name of the file this parser was created for
     * @var string 
     */
    private $_fileName = '';

    /**
     * Creates the parser with according schema
     * @param array $schema schema of the parser
     * @param string $fileName name of the file to Parse
     */
    public function __construct($schema, $fileName) {
        $this->_schema = $schema;
        $this->_fileName = $fileName;
        //Zend_Debug::dump($schema);
    }
    
    public function getImportFileName() {
        return $this->_fileName.'_';
    }
    
    public function getTableName() {
        return $this->_schema['tableName'];
    }
    
    /**
     * Parses a file, which this parser is created for using the scheme
     * Main method
     */
    public function parse() {
        $rowCount = 0;
        $errorCount = 0;
        $file = fopen($this->_fileName,"r");
        
        if (file_exists($this->getImportFileName())) {
            unlink($this->getImportFileName());
            }
        $fileDb = fopen($this->getImportFileName(), "w");
        
        while(! feof($file)) {
            $rowCount+=1;
            try {
                $row = $this->_parseLine(fgets($file));
                if (!is_null($row)){
                    fwrite($fileDb, join(';',$row)."\n");
                }
            } catch (Exception $exc) {
                $errorCount += 1;
                echo 'ERROR: ' .$exc->getMessage().'<br>';
                continue;
            }
        }
        fclose($file);
        fclose($fileDb);
        
        if ($rowCount>0){
            if ($errorCount*100/$rowCount > Config::getInstance()->settings['main']['errorRate']){
                unlink($this->getImportFileName());
                throw new Exception( 'Error rate limit exceeded.'.
                                    ' Error count:' .$errorCount.
                                    '. Row count:' .$rowCount.
                                    '. Filename:'. basename($this->_fileName));
            }
        }
    }
    
    /**
     * Parses single line using scheme
     * @param string $line
     */
    private function _parseLine($line) {
//      echo "To parse:\"$line\"<br>";
        $row = [];
        $currentIndex = 0;
        foreach ($this->_schema['columns'] as $colName => $colSchema) {
            $value = trim(substr($line, $currentIndex,$colSchema['length']));
            $convertedValue = Converter::getInstance()->convert($value, $colSchema);
            if (is_null($convertedValue)) {
                return NULL;
            }
            $row[$colName] = $convertedValue;
            $currentIndex += $colSchema['length'];
        }
//        Zend_Debug::dump($row);
        return $row;
    }
    
}
