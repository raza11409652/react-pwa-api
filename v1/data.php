<?php 
require_once "../config/Connection.php";
require_once "../model/User.php";

/**
 * For security pupose api should conatin header info 
 * and validate user is requesting is valid or not ? 
 */
$response = array("error"=>false ) ;
$response['records'] = array() ; 
$response['error'] = false;
for($i=0;$i<20;$i++){
    $item = array(
        "id"=>$i+1 ,
        "name"=>"Profile {$i}" ,
        "caption"=>"caption {$i}" ,  
        "image"=>"https://images.vexels.com/media/users/3/145908/preview2/52eabf633ca6414e60a7677b0b917d92-male-avatar-maker.jpg" , 
    ); 
    array_push($response['records'] , $item);
}
echo json_encode($response) ; 
?>