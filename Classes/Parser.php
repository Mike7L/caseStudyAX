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
        Zend_Debug::dump($schema);
    }
    
    /**
     * Parses a file, which this parser is created for using the scheme
     * Main method
     */
    public function parse() {
        $rowCount = 0;
        $errorCount = 0;
        $file = fopen($this->_fileName,"r");
        while(! feof($file)) {
            $rowCount+=1;
            try {
                $row = $this->_parseLine(fgets($file));
                if (!is_null($row)){
                    
                }
            } catch (Exception $e) {
                $errorCount += 1;
                echo $e->getMessage().'<br>';
                continue;
            }
          }
        fclose($file);
    }
    
    /**
     * Parses single line using scheme
     * @param string $line
     */
    private function _parseLine($line) {
        echo "To parse:\"$line\"<br>";
        
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
        
        Zend_Debug::dump($row);
        
        return $row;
    }
    
}
