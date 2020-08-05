<?php 
class User{
    private $connection  ;
    private $option = array("cost"=>12) ; 
    function __construct(){
        $conn = new Connection(); 
        $this->connection = $conn->getConnect();
    }
    function getMaxId(){
        $query = "SELECT MAX(user_id) as MAX_ID from user" ;
        $res = mysqli_query($this->connection , $query) ; 
        $data = mysqli_fetch_assoc($res) ;
        return $data['MAX_ID']+1; 
    }
    function formatUid($id){
       if($id<100){
           $id ="00{$id}" ; 
       }
       return "119{$id}" ; 
    }
    function getPassword(){
        $token =  mt_rand(10000 , 99999) ;
        $token = "Ums!@{$token}" ; 
        return $token ;
    }
    function hashStr($str){
        return password_hash($str, PASSWORD_BCRYPT, $this->option);
    }
    function validateHash($str , $hashStr){
        if(password_verify($str , $hashStr)){
          return true;
        }
        return false;
    }
    function getUser($id){
        $query = "SELECT * from user where user_id='{$id}'" ; 
        $res  =mysqli_query($this->connection , $query) ; 
        $data = mysqli_fetch_assoc($res); 
        return $data;
    }
    function getUserByLogin($id){
        $query = "SELECT * from user where user_login_id='{$id}'" ; 
        $res  =mysqli_query($this->connection , $query) ; 
        $data = mysqli_fetch_assoc($res); 
        return $data;
    }
    function insertNew($first ,$last, $date ,$gender  , $password){
        $maxId = $this->getMaxId();
        $uid = $this->formatUid($maxId);
        // var_dump($uid);
        $password = $this->hashStr($password) ; 
        $query = "INSERT INTO user (user_id , user_first_name , user_last_name , user_login_id , user_password , 
        user_gender , user_dob )
        VALUES('{$maxId}' , '{$first}' ,'{$last}' ,'{$uid}' , '{$password}' , '{$gender}' , '{$date}')" ;
        // echo $query;
        $res   = mysqli_query($this->connection , $query) ; 
        if($res){
            $data =$this->getUser($maxId) ; 
            return $data ; 
        }
        return NULL; 
    }
    
}
?>