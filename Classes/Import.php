<?php
/**
* Documentation Block Here
*/

class Import
{

    protected $version = '';
    // 
    public function __construct($version) {
        $this->version = $version;
    }

    

    public function start()
    {
        $files = glob('folder/*.{jpg,png,gif}', GLOB_BRACE);
        foreach($files as $file) {
          //do your work here
        }
    }

}