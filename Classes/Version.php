<?php
/**
 * Holds Information about Schemas,provided in current import version
 */
class Version
{
    /**
     * Holds information about schemas
     * @var array 
     */
    private $_versionData = '';
    
    /**
     * Creates Version 
     * @param string $versionFile Filename with information about schemas
     */
    public function __construct($versionFile) {
        $versionXML = new Zend_Config_XML($versionFile);
        $this->_versionData = $versionXML->toArray();
        echo '<pre>';
        print_r($this->_versionData);
        echo '</pre>';
    }

    /**
     * Returns a schema depending on schema name
     * @param string $schemaName name of requested schema
     * @return array schema
     */
    public function getSchema($schemaName) {
        foreach ($this->_versionData['files'] as $schema) {
            if ($schema['name'] == $schemaName) {
                echo 'YEAAAH';
                return $schema;
            }
        }
        return NULL;
    }


}