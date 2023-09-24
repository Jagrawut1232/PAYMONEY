<?php 

session_start();
require "dbconnect.php";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>เปลี่ยนรหัสผ่าน</title>
    <link href="bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <script src="bootstrap/js/bootstrap.min.js"></script>
</head>
<body>
    <div class="container">
    <div class="col-md-3 badge  border border-secondary">
<form method="post" action="loginchange.php">
    <h3 class="text-success" align="center">เปลี่ยนรหัสผ่าน</h3> <br>
    <select class="form-select border-primary" aria-label="Small select example" name="ADMIN_ID" required>
      <option value="" selected>เลือกผู้ใช้งาน</option>
      <?php 
      $sql="SELECT ADMIN_ID,nameAD FROM Tadmin ORDER BY ADMIN_ID";
      $hand=mysqli_query($connect,$sql);
      while($row=mysqli_fetch_array($hand)){
      ?>
      <option value="<?=$row['ADMIN_ID']?>"><?=$row['nameAD']?></option>
      <?php } ?>
    </select>
   <br> <input type="password" name="pw" class="form-control border border-primary" required placeholder="กรอกรหัสเดิม"> <br>   
   <br> <input type="password" name="newpw" class="form-control border border-success " required placeholder="กรอกรหัสใหม่"> <br>   
    <?php 
    if(isset($_SESSION["error"])){
        echo "<div class='text-danger'>";
        echo $_SESSION["error"];
        echo "</div>";
    }
    ?>
    <input type="submit" value="เปลี่ยนรหัสผ่าน" name="submit" class ="btn btn-primary"><br>
    <a href="index.php"> กลับหน้าหลัก</a> <br> 
</div>
</div>
</body>
</html>
<?php
if(isset($_POST['ADMIN_ID'])){
$ADMIN_ID=$_POST['ADMIN_ID'];
$pw=$_POST['pw'];
$pw=hash('sha512',$pw);
$newpw=$_POST['newpw'];
$newpw=hash('sha512',$newpw);
$sql="SELECT * FROM Tadmin WHERE ADMIN_ID='$ADMIN_ID' AND pw='$pw'";
$result=mysqli_query($connect,$sql);
$row=mysqli_fetch_array($result);
$status=$row['statusAD'];
if($row > 0){
    $sql="UPDATE Tadmin SET 
    pw='$newpw'
    WHERE ADMIN_ID='$ADMIN_ID'";
    $result=mysqli_query($connect,$sql);
    if($result){
        echo "<script> alert('เปลี่ยนรหัสผ่านเรียบร้อย'); </script>";
    }else{
        echo "<script> alert('ไม่แก้ไขรหัสผ่านได้')</script>";
    }
    if($status=='1'){
    $show=header("location:index.php");
    }else{
    $_SESSION['error']="<p>ไม่มีสิทธิ์ใช้งาน</p>";
    $show=header("location:loginchange.php");
    }  
}else{
    $_SESSION['error']="<p> ชื่อผู้ใช้หรือรหัส ไม่ถูกต้อง </p>";
    $show=header("location:loginchange.php");
}
    echo $show;
}    
?>