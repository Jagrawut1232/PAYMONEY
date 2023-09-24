<?php
/* ไฟล์ล็อกอิน
    login.php           ล็อกอินเข้าใช้งานของเคาน์เตอร์ index.php
    login_check.php     ตรวจเช็คการเข้าใช้งาน
    loginchange.php     เปลี่ยนแปลงรหัสเข้าใช้งาน
    loginDR.php         ล็อกอินเข้าใช้งานของแพทย์ fr_exam.php
    loginDRcheck.php    ตรวจเช็คการเข้าใช้งานของแพท์
*/
SESSION_START();
SESSION_DESTROY();
header("location:index.php");
?>
