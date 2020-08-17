<?php


class User {

    public $id;
    public $username;
    public $password;
    public $first_name;
    public $last_name;


    public static function find_all_users(){
        

        return self::exec_query("SELECT * FROM users");

        //echo print_r($result);
    }

    public static function find_user_by_id($id){

        $result_array = self::exec_query("SELECT * FROM users WHERE id =$id LIMIT 1");

        return !empty($result_array) ? array_shift($result_array) : false;

   
    }

    public static function exec_query($sql){
        global $database;

        $result_set = $database -> query($sql);
        
        //array is used to store the multiple record/s we get from the query
        $object_array = array();

        while($row = mysqli_fetch_array($result_set)){
           
            //the multiple rows that we get from database we create a new instance for each one with instantiate method so we can access the values
            //as property in the User instance
            $object_array[] = self::instantiate($row);
        }

        return  $object_array;
    }

    private static function instantiate($record){

        $object = new self;

        //We want to assign values we get from a record to the object properties so we can access
        //it by $object -> username. To do that we loop over the record we pass in as argument
        //Note: object = instance of class

        foreach($record as $attribute => $value){
            //Before we assign the attribute value to the object property we want to check the property we assigning
            //from the record exists as property of object

            if($object-> has_attribute($attribute)){
                
                $object -> $attribute = $value;
            }
        }

        return $object;
    }


    private function has_attribute($attribute){
        
        //get_object_vars takes in a class and returns its props as an array
        $object_properties = get_object_vars($this);

        //array_key_exists checks if a key exists in an array and returns a boolean
        //first arg is the key we want to find in an array
        //second arg is the array we want to find the key in
        return array_key_exists($attribute,$object_properties);
    }
}


?>