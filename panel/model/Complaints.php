<?php 
class Complaints{
    private $connection  ;
    function __construct(){
        $conn = new Connection(); 
        $this->connection = $conn->getConnect();
    }
    function create($category  ,$subCategory , $booking, $date , $remarks){
        $title = $this->getTitle($category);
        $category = mysqli_real_escape_string($this->connection ,$category);
        $subCategory = mysqli_real_escape_string($this->connection , $subCategory);
        $date = mysqli_real_escape_string($this->connection , $date);
        $remarks  =mysqli_real_escape_string($this->connection , $remarks);
        if($remarks==null ||empty($remarks)){
            $remarks = "N/A";
        }

        $query  ="INSERT INTO complaints(complaints_title , complaints_cat , 
        complaints_sub_cat , complaints_booking ,complaints_date , 
        complaints_remarks) VALUES('{$title}' ,'{$category}','{$subCategory}' , '{$booking}' , '{$date}' , '{$remarks}')";
            // echo $query;
        $res  = mysqli_query($this->connection , $query);
        return $res;
    }
    function getTitle($category){
        $query = "SELECT *FROM complaints_issue where complaints_issue_id='{$category}'";
        $res = mysqli_query($this->connection , $query);
        $data = mysqli_fetch_array($res);
        return $data['complaints_issue_topic'];
    }
    function getSubTitle($id){
        $query = "SELECT * from complaints_sub_issue where complaints_sub_issue_id='{$id}'";
        $res = mysqli_query($this->connection , $query);
        $data = mysqli_fetch_array($res);
        return $data['complaints_sub_issue_topic'];
    }

    function getAllOpenComplaints($date){
        $query = "SELECT *  from  complaints where complaints_status!='2' && complaints_date='{$date}'";
        $res = mysqli_query($this->connection , $query);
        $item =array();
        while($data = mysqli_fetch_assoc($res)){
            array_push($item , $data);
        }
        return $item;
    }
    function getStatus($id){
        $query = "SELECT * from  complaints_status where complaints_status_id='{$id}'";
        //  echo $query;
        $res = mysqli_query($this->connection , $query);
        $data = mysqli_fetch_array($res);
        return $data['complaints_status_val'];
    }
}
?>