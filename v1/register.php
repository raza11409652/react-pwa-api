<?php 
require_once "../config/Connection.php";
require_once "../model/User.php";
$response = array("error"=>true) ; 
class Register{
    private $connection; 
    public $user ; 
    function __construct(){
        $conn = new Connection(); 
        $this->connection = $conn->getConnect();
        $this->user = new User();
    }
    function newUser($first , $last , $date , $gender , $password){ 
        $flag = $this->user->insertNew($first , $last , $date  ,$gender , $password);
        return $flag ; 
    }
}
if($_SERVER['REQUEST_METHOD'] == 'POST'){
    $obj = new Register();
    $first = @$_POST['firstName'] ; 
    $last = @$_POST['lastName'] ; 
    $date =@$_POST['date'] ; 
    $gender =@$_POST['gender'] ; 
    if(empty($first)){
        $response['error'] = true ; 
        $response['msg'] = "First name is required" ; 
        echo json_encode($response);
        return ; 
    }
    if(empty($last)){
        $response['error'] = true ; 
        $response['msg'] = "First name is required" ; 
        echo json_encode($response);
        return ; 
    }

    if(empty($date)){
        $response['error'] = true ; 
        $response['msg'] = "Date is required" ; 
        echo json_encode($response);
        return ; 
    }
    if(empty($gender)){
        $response['error'] = true ; 
        $response['msg'] = "Gender is required" ; 
        echo json_encode($response);
        return ; 
    }
    $password = $obj->user->getPassword(); 
    $r = $obj->newUser($first , $last , $date  ,$gender , $password);
    $response['error'] = false ; 
    $response['user'] = $r ; 
    $response['password']  =$password ; 
    $response['msg'] = "Account has been created" ; 
    echo json_encode($response);
    return; 
    
   
}else{

}
?>