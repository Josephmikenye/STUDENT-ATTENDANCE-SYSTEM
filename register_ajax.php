<?php
include 'db_connect.php';
$category = $_POST['category'];
if ($category == "Student"){
    $id_no = $_POST['id_no'];
    $name = $_POST['name'];
    $category = $_POST['category'];
    $class_id = $_POST['class_id'];

    $query = "SELECT * FROM `students` WHERE `id_no` = '$id_no' AND `class_id` = '$class_id'";
    $result = mysqli_query($conn, $query);
    if (mysqli_num_rows($result) > 0) {
        echo json_encode(array("statusCode"=>201));
    } else {
        $sql = "INSERT INTO `students`( `id_no`,`class_id`, `name`) VALUES ('$id_no','$class_id','$name')";
        $result2 =mysqli_query($conn, $sql);
        if ($result2) {
        echo json_encode(array("statusCode"=>200));
      }
   }
} 
mysqli_close($conn);
?>