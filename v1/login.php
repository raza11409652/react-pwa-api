<?php
require_once "../config/Connection.php";
require_once "../model/User.php";
$response = array("error"=>true) ; 
class Login{
    private $connection; 
    public $user ; 
    function __construct(){
        $conn = new Connection(); 
        $this->connection = $conn->getConnect();
        $this->user = new User();
    }
    function verify($password , $hashPassword){
        $flag = $this->user->validateHash($password, $hashPassword);
        return $flag ; 
    }
}
if($_SERVER['REQUEST_METHOD'] == 'POST'){
    // var_dump($_POST);
    $loginId = @$_POST['loginId'];  
    $password = @$_POST['password'] ; 
    if(empty($loginId)){
        $response['error'] = true ; 
        $response['msg'] = "Login id is required"  ;
        $response['error-code'] = 505 ;  
        echo json_encode($response) ; 
        return ; 
    }
    if(empty($password)){
        $response['error'] = true ; 
        $response['msg'] = "Password is required"  ;
        $response['error-code'] = 505 ;  
        echo json_encode($response) ; 
        return ; 
    }

    $obj =new Login();
    $userData = $obj->user->getUserByLogin($loginId) ; 
    if(empty($userData) || $userData==null){
        $response['error'] = true ; 
        $response['msg'] = "Auth failed"  ;
        $response['error-code'] = 404 ; // error login Id not found  
        echo json_encode($response) ; 
        return ;  
    }
    $hashPassword = $userData['user_password'];
   // var_dump($hashPassword);
   $flag = $obj->verify($password , $hashPassword) ; 
//    var_dump($flag);
if(!$flag){
    $response['error'] = true ; 
    $response['msg'] = "Auth failed" ; 
    $response['error-code'] = 404  ; //error
    echo json_encode($response) ;
    return ; 
}

$response['error'] = false ; 
$response['msg'] = "Auth success" ; 
$response['error-code'] = 0  ; //error
$response['user'] = $obj->user->getUserByLogin($loginId); 
echo json_encode($response) ;
return ;


}else{
    $response['error'] = TRUE ; 
    $response['msg'] = "Get method not allowed" ; 
    $response['error-code'] = 505 ; 
    echo json_encode($response);
    return ; 
}

?>