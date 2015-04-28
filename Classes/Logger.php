<?php
/**
 * Logger: Collects Statistics, Writes logs, Emails
 */
class Logger {
    /**
    *
    * @var Logger: one instance is enough
    */
    private static $_instance;
    
    /**
     * Statistics
     * @var array
     */
    private $_stats;
    
    /**
     * Creates Logger
     */
    private function __construct()
    {
        $this->_stats['start'] = date('Y-m-d H:i:s');
        $this->_stats['updates'] = 0;
        $this->_stats['inserts'] = 0;
        $this->_stats['errors'] = 0;
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
    
    /**
     * Could have been used for logging
     * @param string $text
     */
    public function write($text) {
        echo $text."<br>";
    }
    
    /**
     * Notify class about non-critical error
     * @param Exception $error
     */
    public function reportError($error) {
        // we could log it here
        echo $error->getMessage()."<br>";
        $this->_stats['errors'] += 1;
    }

    /**
     * Notify class about new updates
     * @param int $count
     */
    public function reportUpdate($count) {
        $this->_stats['updates'] += $count;
    }
    
    /**
     * Notify class about new inserts
     * @param int $count
     */
    public function reportInsert($count) {
        $this->_stats['inserts'] += $count;
    }
    
    /**
     * Returns import statistics
     * @return array
     */
    public function getStats() {
        return $this->_stats;
    }

    /**
     * sends Email with information about an Error
     * @param Exception $error 
     */
    public function reportCriticalError($error)
    {
        $transport = new Zend_Mail_Transport_Smtp('smtp.gmail.com');
        Zend_Mail::setDefaultTransport($transport);
        $mail = new Zend_Mail();
        $mail->addTo('admin@casestudy.com');

        $mail->setSubject("Error");
        $mail->setBodyText($error->getMessage());
        
        //the Email would be sent if we had proper settings
        //$mail->send($transport);
    }
    
    
}
    
