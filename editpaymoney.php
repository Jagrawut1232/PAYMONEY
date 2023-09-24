<?php 
session_start();
if(!isset($_SESSION['nameAD']))
header("location:login.php");
$ADMIN_ID=$_SESSION['ADMIN_ID'];

require "dbconnect.php"; 
$today=date("Y-m-d");
$id=$_GET['id'];
$sql="SELECT * FROM Tpaymoney WHERE PM_ID='$id'";
$result=mysqli_query($connect,$sql);
$row=mysqli_fetch_array($result);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ดูรายจ่ายกลาง</title>
    <link href="bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <script src="bootstrap/js/bootstrap.min.js"></script>
</head>
<body>
<div class="container col-sm-3">
    <div class="alert alert-success text-center mt-4" role="alert"> <h4>ดูรายจ่ายกลาง </h4> </div>
   
    <form action="editpaymoney.php" method="post" enctype="multipart/form-data">
        <input class="form-control form-control-sm" type="text" name="PM_ID" value="<?=$row['PM_ID']?>"readonly>
        <label>วันที่จ่าย</label>     
        <input class="form-control form-control-sm" type="date" name="datePM" value="<?=$row['datePM']?>" >
        <label>รายการจ่าย</label> 
        <textarea class="form-control form-control-sm"   rows="1"  name="listPM"><?=$row['listPM']?></textarea>     
        <label>จำนวน</label>         
        <input class="form-control form-control-sm" type="decimal" name="pPM" value="<?=$row['pPM']?>">
        <label>จ่ายให้</label>         
        <input class="form-control form-control-sm" type="text" name="whoPM" value="<?=$row['whoPM']?>">
        <label>เลขที่เอกสาร</label>     
        <input class="form-control form-control-sm" type="text" name="invoicePM" value="<?=$row['invoicePM']?>">
        <label>เลขที่สลิป</label>            
        <input class="form-control form-control-sm" type="text" name="slipPM" value="<?=$row['slipPM']?>">
        <label>สาขา</label>           
        <select class="form-select" name="branchPM" >
            <?php
            if($row['branchPM']==1){ $branch='แม่สอด';}
            elseif($row['branchPM']==2){ $branch='ระยอง';}
            elseif($row['branchPM']==3){ $branch='พิษณุโลก1';}
            elseif($row['branchPM']==4){ $branch='พิษณุโลก2';}
            ?>
            <option value="<?=$row['branchPM']?>" selected><?=$branch?></option>
            <option value="1">แม่สอด</option>
            <option value="2">ระยอง</option>
            <option value="3">พิษณุโลก1</option>
            <option value="4">พิษณุโลก2</option>
        </select>                      
        <label>หมายเหตุ</label>       
        <textarea class="form-control form-control-sm"   rows="1"  name="notePM"><?=$row['notePM']?></textarea> 
        <label>รูปภาพ</label>       
        <input class="form-control form-control-sm" type="file" name="PMimg" >
        <input class="form-control form-control-sm"  type="text" name="textimg" hidden   value=<?=$row['PMimg'] ?> >
        <br>
        <button class="btn btn-outline-success" type="submit">แก้ไข</button> 
        <button class="btn btn-outline-danger" type="reset">ยกเลิก</button>
        <a class="btn btn-outline-secondary" href="paymoneylist.php" role="button">ดูรายจ่าย</a>
        <a class="btn btn-outline-secondary" href="index.php" role="button">กลับหน้าหลัก</a>
        <img class="mt-4" src="PMimg/<?=$row['PMimg']?>" width="300px">
    </form>
</div>
<?php  
if(isset($_POST['PM_ID'])){
$PM_ID=$_POST['PM_ID'];
$datePM=$_POST["datePM"];
$listPM=$_POST["listPM"];
$pPM=$_POST["pPM"];
$whoPM=$_POST['whoPM'];
$invoicePM=$_POST["invoicePM"];
$slipPM=$_POST["slipPM"];
$branchPM=$_POST["branchPM"];
$notePM=$_POST["notePM"];
$image=$_POST["textimg"];
//อัพโหลดรูปภาพ
if (is_uploaded_file($_FILES['PMimg']['tmp_name'])) {
    $new_image_name = 'PM_'.uniqid().".".pathinfo(basename($_FILES['PMimg']['name']), PATHINFO_EXTENSION);
    $image_upload_path = "./PMimg/".$new_image_name;
    move_uploaded_file($_FILES['PMimg']['tmp_name'],$image_upload_path);
    } else {
    $new_image_name = "$image";
    }
$sql1="UPDATE Tpaymoney SET 
datePM='$datePM',
listPM='$listPM',
pPM='$pPM',
whoPM='$whoPM',
invoicePM='$invoicePM',
slipPM='$slipPM',
branchPM='$branchPM',
notePM='$notePM',
PMimg='$new_image_name' 
WHERE PM_ID='$PM_ID'";

$result1=mysqli_query($connect,$sql1);
if($result1){
    echo "<script> alert('บันทึกข้อมูลเรียบร้อย'); </script>";
    echo "<script> window.location='editpaymoney.php?id=$PM_ID'; </script>";
}else{
    echo "<script> alert('ไม่สามารถบันทึกข้อมูลได้')</script>";
}
}
?>

</body>
</html>
<?php mysqli_close($connect) ?>