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
        //$versionXML = new Zend_Config_XML($versionFile.'.xml');
        $versionJSON = new Zend_Config_JSON($versionFile.'.json');
        $this->_versionData = $versionJSON->toArray();
        //Zend_Debug::dump($this->_versionData);
    }

    /**
     * Returns a schema depending on schema name
     * @param string $schemaName name of requested schema
     * @return array schema
     */
    public function getSchema($schemaName) {
        if (array_key_exists($schemaName, $this->_versionData)) {
            return $this->_versionData[$schemaName];
        } 
        return NULL;
    }


}