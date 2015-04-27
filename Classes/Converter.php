<?php
/**
 * A class with conversion and validation functions
 */
class Converter {
    /**
    *
    * @var Converter: one instance is enough
    */
    private static $_instance;

    /**
     * Returns an instance, if there is no instance created yet, creates one
     * @return Converter
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
     * Validates and Converts $var to Int
     * @param string $var
     */
    private function _convertint($var) {
        if (is_numeric($var) && (intval($var)==$var))  {
            return intval($var);
        }
        return NULL;
    }
    
    /**
     * Validates and Converts $var to float
     * @param string $var
     */
    private function _convertfloat($var) {
        if (is_numeric($var))  {
            return floatval($var);
        }
        return NULL;        
    }
    
    /**
     * Validates and Converts $var to Date
     * @param string $var
     */
    private function _convertdate($var) {
        
        $d = DateTime::createFromFormat('d.m.Y', $var);
        if ($d && $d->format('d.m.Y') == $var)  {
            return $var;
        }
        return NULL;  
    }
    
    /**
     * Validates and Converts $var to Int
     * @param string $var
     */
    private function _convertstring($var) {
        if (is_string($var))  {
            return $var;
        }
        return NULL;  
    }

    /**
     * Main function. Checks that $col matches the $colSchema and converts it
     * @param string $col Value to convert
     * @param array $colSchema Schema
     * @return string converted value of the column or null
     */
    public function convert($col, $colSchema) {
        //ignoreValues - these values are always accepted, without checking
        // 
        if (array_key_exists('ignoreValues', $colSchema)) {
            foreach ($colSchema['ignoreValues'] as $ignoreValue) {
                if ($col == $ignoreValue){
                    return $col;
                }
            }
        }
        //allowedValues - list of possible values, all others are wrong
        if (array_key_exists('allowedValues', $colSchema)) {
            foreach ($colSchema['allowedValues'] as $allowedValue) {
                if ($col == $allowedValue) {
                    return $col;
                }
            }
            throw new Exception('Value "'.$col. '" is not allowed');
        }
        
        //decides which convert function will be used
        $convertFunction = '_convert' .$colSchema['type'];
        $value = $this->$convertFunction($col);
        
        if (is_null($value)) {
            throw new Exception('"'.$col. '" is not a valid '. $colSchema['type']);
        }
        return $value;
    }
}
