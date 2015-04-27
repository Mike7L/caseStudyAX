<?php
/**
 * Description of Config
 */
class Config {

    /**
    *
    * @var Config: one instance is enough
    */
    private static $_instance;
    
    
    public $settings;

    /**
     * Creates Config
     */
    private function __construct()
    {
        $this->settings = new Zend_Config_INI('../Config/config.ini');
    }

    /**
     * Returns an instance, if there is no instance created yet, creates one
     * @return Config
     */
    public static function getInstance()
    {
      if ( is_null( self::$_instance ) )
      {
        self::$_instance = new self();
      }
      return self::$_instance;
    }
}
