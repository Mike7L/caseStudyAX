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
        Zend_Debug::dump($schema);
    }
    
    /**
     * Parses a file, which this parser is created for using the scheme
     * Main method
     */
    public function parse() {
        $file = fopen($this->_fileName,"r");
        while(! feof($file)) {
            $this->_parseLine(fgets($file));
            break;
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
            $value = substr($line, $currentIndex,$colSchema['length']);
            $currentIndex += $colSchema['length'];
            Zend_Debug::dump($colSchema);
            $row[$colName] = Converter::getInstance()->convert($value, $colSchema);
        }
        
        echo join(";", $row);
        
        return $row;
    }
    
}
