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

$ADMIN_ID=$_POST['ADMIN_ID'];
$pw=$_POST['pw'];
$pw=hash('sha512',$pw);

$sql="SELECT * FROM Tadmin WHERE ADMIN_ID='$ADMIN_ID' AND pw='$pw'";
$result=mysqli_query($connect,$sql);
$row=mysqli_fetch_array($result);
$status=$row['statusAD'];
if($row > 0){
    $_SESSION['ADMIN_ID']=$row['ADMIN_ID'];
    $_SESSION['pw']=$row['pw'];
    $_SESSION['nameAD']=$row['nameAD'];
    if($status=='1'){
    $show=header("location:index.php");  
    }else{
    $_SESSION['error']="<p>ไม่มีสิทธิ์ใช้งาน</p>";
    $show=header("location:login.php");
    }  
}else{
    $_SESSION['error']="<p> ชื่อผู้ใช้หรือรหัส ไม่ถูกต้อง </p>";
    $show=header("location:login.php");
}
    echo $show;
?>