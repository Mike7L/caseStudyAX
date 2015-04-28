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
    private $_versionData;
    
    /**
     * Creates Version 
     * @param string $versionFile Filename with information about schemas
     */
    public function __construct($versionFile) {
        $jsondata = file_get_contents(APP_ROOT.'Config/version.json');
        $this->_versionData = json_decode($jsondata, true);
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