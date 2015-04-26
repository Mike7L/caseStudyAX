<?php
/**
* Documentation Block Here
*/

class Version
{
    protected $versionData = '';
    // 
    public function __construct($versionFile) {
        
        $versionXML = new Zend_Config_XML($versionFile);
        $this->versionData = $versionXML->toArray();

        Zend_Debug::dump($this->versionData);
    }


}