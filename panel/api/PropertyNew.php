<?php 
require_once "../../base_config/Connection.php";
require_once "../model/Admin.php";
require_once "../model/Property.php";
require_once "../controller/Utils.php";
$resposne = array("error" =>true ) ;
session_start();
// var_dump($_SESSION);

class PropertyNew{
    private $connection  ; 
    public $admin  , $property;  
    function __construct(){
        $conn = new Connection(); 
        $this->connection = $conn->getConnect();
        $this->admin = new Admin();
        $this->property = new Property();
    }
    function insert($id , $name , $uid , $lat ,$lng , $address , $image , $type , $room , $listingType , $price , $admin){
        $query ="Insert into property (property_id , property_uid , property_name , property_lat , 
        property_long , property_address , property_cover_image , property_type , property_total_room,
        property_listing_type , property_price , property_added_by)values('{$id}' ,'{$uid}' ,'{$name}' , 
        '{$lat}' , '{$lng}' ,'{$address}' , '{$image}' , {$type} , '{$room}' , '{$listingType}' ,
        '{$price}' , '{$admin}')" ;
        // echo $query;
        $res = mysqli_query($this->connection , $query) ; 
        return $res; 
    }
    
}
if($_SERVER['REQUEST_METHOD'] == 'POST'){
    //  var_dump($_POST);
    $obj = new PropertyNew();
    $allowedSize = 500000 ; 
    @$name = $_POST['name'] ; 
    @$lat = $_POST['latitude'] ; 
    @$lng = $_POST['longitude'] ; 
    @$address = $_POST['address'] ; 
    @$type= $_POST['type'] ;
    @$listingType = $_POST['listingtype'] ;
    @$room = $_POST['room'] ; 
    @$price = $_POST['price'] ; 
    $image = $_FILES['image']['name'];
    $target_dir = "../upload/";
    // var_dump($image);
    $imageName = md5($name).mt_rand(1000 , 9999);
    $target_file = $target_dir .$imageName. basename($image);
    $uploadedImageName = "/../upload/".$imageName. basename($image);
    $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
    $check = getimagesize($_FILES["image"]["tmp_name"]);
    // var_dump($obj->property);
    $propertyId = $obj->property->getMaxId() ; 
    $uid = $obj->property->generateUid($propertyId);
    // var_dump($uid);

    @$adminEmail = $_SESSION['loggedInEmail']  ; 
    @$adminData = $obj->admin->getAdmin($adminEmail)  ;
    @$adminId = $adminData['admin_id'];
    if(empty($adminId)){
        return ; 
    }
    $fileSize = $_FILES['image']['size'];
    if($check!==false){
        if($fileSize>$allowedSize){
            $resposne['error']  =true ; 
            $resposne['msg'] = "Image should be less than 500KB" ; 
            $resposne['error-code']  =908;
            echo json_encode($resposne) ; 
            return ;  
        }

        if(@ move_uploaded_file($_FILES['image']['tmp_name'] ,$target_file )){
            // echo $uploadedImageName;
            $uploadedImageURL =  'http://' . $_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']) . $uploadedImageName;
            // echo $uploadedImageURL;
            $flag = $obj->insert($propertyId , $name , $uid ,$lat , $lng , $address , $uploadedImageURL  , $type , $room  , $listingType , $price , $adminId) ; 
            //  var_dump($flag);
            if($flag){
                $resposne['error'] = false ; 
                $resposne['msg'] = "Property Added UID {$uid}"; 
                $resposne['error-code'] = 909 ; 
                echo json_encode($resposne) ; 
                return ;
            }else{
                $resposne['error'] = true ; 
                $resposne['msg'] = "Error while uploading file"; 
                $resposne['error-code'] = 909 ; 
                echo json_encode($resposne) ; 
                return ; 
            }


        }else{
        $resposne['error'] = true ; 
        $resposne['msg'] = "Error while uploading file"; 
        $resposne['error-code'] = 909 ; 
        echo json_encode($resposne) ; 
        return ;
        }
    }else{
        $resposne['error'] = true ; 
        $resposne['msg'] = "File format is not allowed"; 
        $resposne['error-code'] = 909 ; 
        echo json_encode($resposne) ; 
        return ; 
    }



}else{

}
?>