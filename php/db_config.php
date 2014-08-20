<?php

class database
{
    public $dbh;
    private static $instance;

    private function __construct()
    {
        $this->dbh = new PDO('mysql:host=localhost;dbname=animolibrosimple', "root", "");
    }

    public static function getInstance()
    {
        if (!isset(self::$instance))
        {
            $object = __CLASS__;
            self::$instance = new $object;
        }
        return self::$instance;
    }
}



?>