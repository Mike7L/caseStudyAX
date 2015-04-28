<?php
/**
 * Config holds configuration for the Application
 */
class Config {

    /**
    * @var Config: one instance is enough
    */
    private static $_instance;
    
    /**
     * @var array Application settings
     */
    public $settings;

    /**
     * Creates Config
     */
    private function __construct()
    {
        $this->settings = parse_ini_file(APP_ROOT.'Config/settings.ini', true);
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
