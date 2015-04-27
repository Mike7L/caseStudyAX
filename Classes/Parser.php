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
    private $_fileName = '';

    /**
     * Creates the parser with according schema
     * @param array $schema schema of the parser
     * @param string $fileName name of the file to Parse
     */
    public function __construct($schema, $fileName) {
        $this->_schema = $schema;
        $this->_fileName = $fileName;
       // Zend_Debug::dump($schema);
    }
    
    /**
     * Parses a file, which this parser is created for using the scheme
     * Main method
     */
    public function parse() {
        $errorCount = 0;
        $file = fopen($this->_fileName,"r");
        while(! feof($file)) {
            try {
                $this->_parseLine(fgets($file));
            } catch (Exception $e) {
                $errorCount += 1;
                echo $e->getMessage();
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
        Zend_Debug::dump($line);
        $row = [];
        $currentIndex = 0;
        foreach ($this->_schema['columns'] as $colName => $colSchema) {
            $value = trim(substr($line, $currentIndex,$colSchema['length']));
            $currentIndex += $colSchema['length'];
            $row[$colName] = Converter::getInstance()->convert($value, $colSchema);
        }
        
        Zend_Debug::dump($row);
        
        return $row;
    }
    
}
