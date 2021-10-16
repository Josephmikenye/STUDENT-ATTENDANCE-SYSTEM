<!DOCTYPE html>
<html lang="en">
<?php 
session_start();
include('./db_connect.php');
ob_start();
if(!isset($_SESSION['system'])){
	$system = $conn->query("SELECT * FROM system_settings limit 1")->fetch_array();
	foreach($system as $k => $v){
		$_SESSION['system'][$k] = $v;
	}
}
ob_end_flush();
?>
<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title><?php echo $_SESSION['system']['name'] ?></title>
 	

<?php include('./header.php'); ?>
<?php 
if(isset($_SESSION['login_id']))
header("location:index.php?page=home");

?>

</head>
<style>
  body{
		width: 100%;
	    height: calc(100%);
	    position: fixed;
	    top:0;
	    left: 0
	}
	main#main{
		width:100%;
		height: calc(100%);
		display: flex;
	}
</style>

<body class="bg-dark">
<main id="main">
  	
<div class="align-self-center w-100">
<h4 class="text-white text-center"><b><?php echo $_SESSION['system']['name'] ?></b></h4>
<div id="register-center" class="bg-dark row justify-content-center">
    <div class="card col-md-4">
        <div class="card-body">
            <form id="register-form" action="" method="post">
            <div class="form-group">
                <label for="" class="control-label">Category</label>
                    <select id="category" name="category" class="custom-select select2" onchange="hideclass()">
                    <option value=""></option>
                    <option value="Student">Student</option>
                    <!-- <option value="Faculty">Lecturer</option> -->
                    </select>
            </div>
            <div class="form-group" id="classidDiv">
                <label for="" class="control-label">Class</label>
                    <select name="class_id" id="class_id" class="custom-select select2">
                    <option value=""></option>
                    <?php
                    $class = $conn->query("SELECT c.*,concat(co.course,' ',c.level,'-',c.section) as `class` FROM `class` c inner join courses co on co.id = c.course_id order by concat(co.course,' ',c.level,'-',c.section) asc");
                    while($row=$class->fetch_assoc()):
                    ?>
                    <option value="<?php echo $row['id'] ?>" <?php echo isset($class_id) && $class_id == $row['id'] ? 'selected' : '' ?>><?php echo $row['class'] ?></option>
                    <?php endwhile; ?>
                    </select>
            </div>
            <div class="form-group">
                <label for="" class="control-label">Adm No.</label>
                <input type="text" id="id_no" name="id_no" class="form-control">
            </div>
            <div class="form-group">
                <label for="" class="control-label">Full Name</label>
                <input type="text" id="name" name="name" class="form-control">
            </div>
            <div class="form-group" id="phonediv" style="display: none;">
                <label for="" class="control-label">Phone</label>
                <input type="number" id="contact" name="contact" class="form-control">
            </div>
            <div class="form-group" id="emaildiv" style="display: none;">
                <label for="" class="control-label">Email</label>
                <input type="email" id="email" name="email" class="form-control">
            </div>
            <div class="form-group"id="passdiv" style="display: none;">
                <label for="" class="control-label">Password</label>
                <input type="password" id="password" name="password" class="form-control" pattern="^(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d]{8,}$"
title="Password must be minimum eight characters, at least one letter and one number">
            </div>
                <center><button class="btn-sm btn-block btn-wave col-md-4 btn-primary" id="RegisterBtn">Register</button></center>
            </form>
            <br>
            <div class="float-right" style="font-size:1.2em"><strong>Already Registered ?</strong> <a href="login.php"><strong>Login</strong></a></div>
        </div>		 
  		</div>
  		</div>
  		</div>
</main>

<a href="#" class="back-to-top"><i class="icofont-simple-up"></i></a>
</body>
<script>
$(document).ready(function() {
  $('#RegisterBtn').on('click', function() {
    var category = $('#category').val();
    if(category = "Student"){
      var id_no = $('#id_no').val();
      var name = $('#name').val();
      var category = $('#category').val();
      var class_id = $('#class_id').val();
      if(category!="" && name!="" && id_no!="" && id_no!=""){
      $.ajax({
          url: "register_ajax.php",
          type: "POST",
          data: {
              id_no : id_no,
              name: name,
              category : category,
              class_id : class_id		
          },
          cache: false,
          success: function(dataResult){
              var dataResult = JSON.parse(dataResult);
              if(dataResult.statusCode==201){
                alert("Student already registered for this Class !");
            }else if(dataResult.statusCode==200){
              $('#register-form').find('input:text').val('');
              alert("Registered successfully !"); 
            }  	   
          }
        });
      }
      else{
      alert('Please fill all the field !');
     }
    }
	});
});
</script>

<script>
  $('.select2').select2({
    placeholder:"Please Select here",
    width:'100%'
  })
  function hideclass() { 
      var cat = document.getElementById("category");
      if(cat.value == "Faculty"){
        $("#classidDiv").hide();
        $("#phonediv").show();
        $("#emaildiv").show();
        $("#passdiv").show();
      }else{
        $("#classidDiv").show();
        $("#phonediv").hide();
        $("#emaildiv").hide();
        $("#passdiv").hide();
      }   
  }   
</script>	

</html>