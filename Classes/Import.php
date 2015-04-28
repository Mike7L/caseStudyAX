<?php
require_once 'Classes/Parser.php';

/**
 * Main import class
 */
class Import
{
    /**
     * Holds information about schemas for current import
     * @var Version 
     */
    private $_version;
    private $_database;

    /**
     * Creates Import
     * @param Version $version
     */
    public function __construct($version, $database) {
        $this->_version = $version;
        $this->_database = $database;
    }
    
    
    /**
     * starts the import, searches for the *.dat files in a loop
     * and feeds them to the parsers.
     */
    public function start() {
        $fileNames = glob(APP_ROOT.'Data/*.dat', GLOB_BRACE);
        foreach($fileNames as $fileName) {
            try {
                $parser = $this->_getParser($fileName);
                if (!is_null($parser)){
                    $fileName = $parser->parse();
                    $this->_database->importFile($parser->getImportFileName(),
                                                 $parser->getTableName());
                    //unlink($parser->getImportFileName());
                }
            } catch (Exception $exc) {
                echo 'ERROR: ' .$exc->getMessage().'<br>';
                continue;
            }
        }
    }
    /**
     * Returns parser according to $fileName
     * @param string $fileName
     * @return Parser
     */
    private function _getParser($fileName) {
        $schemaName = basename($fileName);
        $schema = $this->_version->getSchema($schemaName); 
        if (!is_null($schema)) {
            return new Parser($schema, $fileName);
        }
        return null;
    }
    
}