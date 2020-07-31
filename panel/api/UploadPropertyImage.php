<?php 
require_once "../../base_config/Connection.php";
require_once "../model/Admin.php";
require_once "../controller/Utils.php";
$response = array("error" =>true );
class UploadPropertyImage{
    private $connection  ; 
    public $admin ;  
    function __construct(){
        $conn = new Connection(); 
        $this->connection = $conn->getConnect();
        $this->admin = new Admin();
    }
    function upload($url , $title , $property){
        $query = "Insert into property_image (property_image_url,property_image_ref , property_image_title)
        values('{$url}','{$property}','{$title}')";
        $res = mysqli_query($this->connection , $query)  ;
        return $res;
    }
}
if($_SERVER['REQUEST_METHOD'] == 'POST'){
    $allowedSize = 500000;
    $header = getallheaders() ; 
    @$authToken = $header['auth-token'] ; 
    $object = new UploadPropertyImage();
    if(empty($authToken) || $authToken ==null){
        $response['error'] = true ;
        $response['msg'] = "Please refresh the page and try again" ; 
        $response['error-code'] = 908 ; //No Auth token found
        echo json_encode($response) ; 
        return;
    }
    if(!$object->admin->validateSession($authToken)){
        $response['error'] = true ;
        $response['msg'] = "Please refresh the page and try again" ; 
        $response['error-code'] = 908 ; //No auth-token not valid
        echo json_encode($response) ; 
        return;
    }
    // var_dump($_FILES); 
    // var_dump($_POST); 
   
    // var_dump($image); 
    @ $title = $_POST['title'] ; 
    @ $property = $_POST['property'] ;
    // var_dump($title); 
    if(empty($title)){
        $response['error'] = true ; 
        $response['msg'] = "Image label is required" ; 
        $response['error-code'] = 98 ; 
        echo json_encode($response); 
        return ; 
    } 
    if(empty($property)){
        return ; 
    }

    @ $image = $_FILES['image']['name'] ; 
    $target_dir = "../upload/";
    $imageName = md5($title).mt_rand(1000 , 9999);
    $target_file = $target_dir .$imageName. basename($image);
    $uploadedImageName = "/../upload/".$imageName. basename($image);
    $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
    @$check = getimagesize(@$_FILES["image"]["tmp_name"]);
    if(!$check){
        $response['error'] = true ; 
        $response['msg'] = "Error with image" ; 
        $response['error-code'] = 99 ; 
        echo json_encode($response); 
        return ;
    }
    $fileSize = $_FILES['image']['size'];
    // var_dump($fileSize);

    if($fileSize>$allowedSize){
        $response['error'] = true ; 
        $response['msg'] = "Image sholud be less than 500 KB" ; 
        $response['error-code'] = 99 ; 
        echo json_encode($response); 
        return ;
    }

     @ $flag = move_uploaded_file($_FILES['image']['tmp_name'] , $target_file);
    // var_dump($flag);
    if(!$flag){
        $response['error'] = true ; 
        $response['msg'] = "Error while uploading image" ; 
        $response['error-code'] = 99 ; 
        echo json_encode($response); 
        return ; 
    }


    $uploadedImageURL =  'http://' . $_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']) . $uploadedImageName;


    // var_dump($uploadedImageURL);
    $flag = $object->upload($uploadedImageURL ,$title ,$property);
    // var_dump($flag);
    if($flag){
        $response['error'] = false ; 
        $response['msg'] = "Upload Success";
        $response['error-code'] = 0;
        echo json_encode($response);  
        return;
    }


}else{

}
?>