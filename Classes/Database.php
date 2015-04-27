<?php
/**
 * DatabaseClass
 */
class Database {
    
    /**
     * Creates database connection
     * @param Version $version
     */
    public function __construct($version) {
        $db = Zend_Db::factory($config->database);
    }
}
