<?php
session_start();
if(!isset($_SESSION['nameAD']))
header("location:login.php");
$ADMIN_ID=$_SESSION['ADMIN_ID'];
require "dbconnect.php"; 
$today=date("Y-m-d");
$month=date("F");?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>บันทึกรายจ่ายกลาง</title>
    <link href="bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <script src="bootstrap/js/bootstrap.min.js"></script>
</head>
<body>
<div class="container col-sm-4">
    <div class="alert alert-success text-center mt-4" role="alert"> <h4>บันทึกรายจ่ายกลาง </h4> </div>
    
    <form action="fr_paymoney.php" method="post" enctype="multipart/form-data">
        <input class="form-control form-control-sm" type="date" name="PM_ID" value="hello" hidden>
        <label>วันที่จ่าย</label>     
        <input class="form-control form-control-sm" type="date" name="datePM" value="<?=$today?>" required>
        <label>รายการจ่าย</label>        
        <input class="form-control form-control-sm" type="text" name="listPM" placeholder="" required> 
        <label>จำนวน</label>         
        <input class="form-control form-control-sm" type="decimal" name="pPM" placeholder="บาท" required>
        <label>จ่ายให้</label>     
        <input class="form-control form-control-sm" type="text" name="whoPM" placeholder="">
        <label>เลขที่เอกสาร</label>     
        <input class="form-control form-control-sm" type="text" name="invoicePM" placeholder="">
        <label>เลขที่สลิป</label>            
        <input class="form-control form-control-sm" type="text" name="slipPM" placeholder="">
        <label>สาขา</label>           
        <select class="form-select" name="branchPM" required >
            <option value="" selected>เลือกสาขา</option>
            <option value="1">แม่สอด</option>
            <option value="2">ระยอง</option>
            <option value="3">พิษณุโลก1</option>
            <option value="4">พิษณุโลก2</option>
        </select>                      
        <label>หมายเหตุ</label>       
        <textarea class="form-control form-control-sm"   rows="1"  name="notePM"></textarea> 
        <label>รูปภาพ</label>       
        <input class="form-control form-control-sm" type="file" name="PMimg" >
        <br>
        <button class="btn btn-outline-success" type="submit">SAVE</button> 
        <button class="btn btn-outline-danger" type="reset">CANCEL</button>
        <a class="btn btn-outline-secondary" href="paymoneylist.php" role="button">ดูรายจ่าย</a>
        <a class="btn btn-outline-secondary" href="index.php" role="button">กลับหน้าหลัก</a>
    </form>
</div>
<?php  
if(isset($_POST['PM_ID'])){
$datePM=$_POST["datePM"];
$listPM=$_POST["listPM"];
$pPM=$_POST["pPM"];
$whoPM=$_POST['whoPM'];
$invoicePM=$_POST["invoicePM"];
$slipPM=$_POST["slipPM"];
$branchPM=$_POST["branchPM"];
$notePM=$_POST["notePM"];

//อัพโหลดรูปภาพ
if (is_uploaded_file($_FILES['PMimg']['tmp_name'])) {
    $new_image_name = 'PM_'.uniqid().".".pathinfo(basename($_FILES['PMimg']['name']), PATHINFO_EXTENSION);
    $image_upload_path = "./PMimg/".$new_image_name;
    move_uploaded_file($_FILES['PMimg']['tmp_name'],$image_upload_path);
    } else {
    $new_image_name = "";
    }


$sql1="INSERT INTO Tpaymoney (datePM,monthPM,listPM,pPM,whoPM,invoicePM,slipPM,branchPM,notePM,PMimg)
      VALUE('$datePM','$month','$listPM','$pPM','$whoPM','$invoicePM','$slipPM','$branchPM','$notePM','$new_image_name')";
$result1=mysqli_query($connect,$sql1);
if($result1){
    echo "<script> alert('บันทึกข้อมูลเรียบร้อย'); </script>";
    echo "<script> window.location='fr_paymoney.php'; </script>";
}else{
    echo "<script> alert('ไม่สามารถบันทึกข้อมูลได้')</script>";
}
}
?>

</body>
</html>
<?php mysqli_close($connect) ?>