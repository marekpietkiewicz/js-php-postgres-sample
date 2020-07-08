<?php

namespace MarekApp;

class Conn
{
   private static $conn;
 
   /**
    * Connect to the database and return an instance of \PDO object
    * @return \PDO
    * @throws \Exception
    */
   public function connect() {

       $params = parse_ini_file('db.ini');
       if ($params === false) {
         throw new \Exception("Error reading database configuration file");
       }
       
      $conStr = sprintf("pgsql:host=%s;port=%d;dbname=%s;user=%s;password=%s", 
         $params['host'], 
         $params['port'], 
         $params['db'], 
         $params['user'], 
         $params['pass']);

       $pdo = new \PDO($conStr);
       $pdo->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);

       return $pdo;
   }

   /**
    * return an instance of the Connection object
    * @return type
    */
   public static function get() {
      if (null === static::$conn) {
         static::$conn = new static();
      }
      return static::$conn;
   }

   
   public function __construct() {
   }


}