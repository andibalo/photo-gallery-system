<?php

    require_once('new_config.php');

    class Database{

        public $connection;

        function __construct()
        {   
            $this -> connect_db();
        }

        public function connect_db(){

            $this -> connection = new mysqli(DB_HOST,DB_USER,DB_PASS,DB_NAME);

            if($this -> connection -> connect_errno){
               die("Failed to connect to database error:" );
            } 

        }


        public function query($sql){
            
            $result = $this -> connection -> query($sql);

            $this -> confirm_query($result);

            return $result;
        }

        private function confirm_query($result){

            if(!$result){
                die('Query Failed');
            }
        }

        public function escape_string($string){

            $escaped_string = $this -> connection -> real_escape_string($string);

            return $escaped_string;
        }

    }

    $database = new Database()
?>

