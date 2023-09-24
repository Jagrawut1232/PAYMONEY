<?php
 /* ไฟล์ล็อกอิน
    login.php           ล็อกอินเข้าใช้งานของเคาน์เตอร์ index.php
    login_check.php     ตรวจเช็คการเข้าใช้งาน
    loginchange.php     เปลี่ยนแปลงรหัสเข้าใช้งาน
    loginDR.php         ล็อกอินเข้าใช้งานของแพทย์ fr_exam.php
    loginDRcheck.php    ตรวจเช็คการเข้าใช้งานของแพท์
*/
session_start();
require "dbconnect.php";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>เข้าใช้งาน</title>
    <link href="bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <script src="bootstrap/js/bootstrap.min.js"></script>
</head>
<body>
    <div class="container">
    <div class="col-md-3 badge  border border-secondary">
<form method="post" action="login_check.php">
<h3 class="text-success" align="center">เข้าใช้งานระบบ</h3> <br>
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
   <br> <input type="password" name="pw" class="form-control" required placeholder="กรอกรหัส"> <br>  
    <?php 
    if(isset($_SESSION["error"])){
        echo "<div class='text-danger'>";
        echo $_SESSION["error"];
        echo "</div>";
    }
    ?>
    <input type="submit" value="เข้าใช้งาน" name="submit" class ="btn btn-primary"><br>
    <a href="index.php"> กลับหน้าหลัก</a>   
    <br> 
</div>
</div>
</body>
</html>