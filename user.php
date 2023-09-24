<?php 
session_start();
if(!isset($_SESSION['nameAD']))
header("location:login.php");
$ADMIN_ID=$_SESSION['ADMIN_ID'];

require "dbconnect.php"; ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ผู้ใช้งาน</title>
    <link href="bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <script src="bootstrap/js/bootstrap.min.js"></script>
</head>
<body>

    <div class="alert alert-success text-center mt-4 col-sm-8" role="alert"> <h4>ผู้ใช้งาน</h4> </div>
    <form action="user.php" method="post"> 
        <label>เพิ่มผู้ใช้งาน</label>       
        <div class="input-group input-group-sm ">
            <div class="col-1">
                <input class="form-control form-control-sm"  type="number" name="ADMIN_ID" maxlength="1" placeholder="เพิ่ม">
            </div>
            <div class="col-2">     
                <input class="form-control form-control-sm" type="text"   name="nameAD" placeholder="ชื่อผู้ใช้งาน" required>
            </div>    
            <div class="col-1">     
                <input class="form-control form-control-sm" type="password"   name="pw"  required>
            </div>
            <div class="col-1">     
            <select class="form-select form-select-sm" name="statusAD" required >
                <option value="" selected>สถานะ</option>
                <option value="0">ถูกระงับ</option>
                <option value="1">ใช้งานได้</option>
            </select>  
            </div>
            <div class="col-1">     
            <textarea  class="form-control form-control-sm" rows="1"      name="noteAD" placeholder="บันทึก"></textarea>
            </div>  
            <button    class="btn btn-sm btn-outline-info"  type="submit">บันทึก</button>
            <button    class="btn btn-sm btn-outline-danger"type="reset"> ยกเลิก</button>
            <a class="btn btn-sm btn-outline-secondary" href="index.php" role="button">กลับหน้าหลัก</a>
        </div>
        <div class="input-group">
            <div class="col-1"> 
            <span  class="input-group-text">รหัส</span> 
            </div>   
            <div class="col-2"> 
            <span  class="input-group-text">ผู้ใช้งาน</span> 
            </div> 
            <div class="col-1">     
            <span  class="input-group-text">รหัสผ่าน</span> 
            </div>
            <div class="col-1">     
            <span  class="input-group-text">สถานะ</span> 
            </div>
            <span  class="input-group-text">บันทึก&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span> 
        </div>   
    </form>

<?php // บันทึกข้อมูลในฟอร์มเข้าตาราง
if(isset($_POST["ADMIN_ID"])){
$ADMIN_ID=$_POST["ADMIN_ID"];
    // เช็ครหัสซ้ำหรือไม่
$check="SELECT ADMIN_ID FROM Tadmin WHERE ADMIN_ID='$ADMIN_ID'";
$result=mysqli_query($connect,$check);
$num=mysqli_num_rows($result);
if($num>0){
    echo "<script> alert('รหัสซ้ำ')</script>";
    echo "<script> window.location='user.php'; </script>";
}else{
$ADMIN_ID=$_POST["ADMIN_ID"];
$nameAD=$_POST["nameAD"];
$pw=$_POST["pw"];
$statusAD=$_POST["statusAD"];
$noteAD=$_POST["noteAD"];
$pw=hash('sha512',$pw);
$sql1="INSERT INTO Tadmin (ADMIN_ID,nameAD,pw,statusAD,noteAD)
      VALUE('$ADMIN_ID','$nameAD','$pw','$statusAD','$noteAD')";
$result1=mysqli_query($connect,$sql1);
if($result1){
    echo "<script> window.location='user.php'; </script>";
}else{
    echo "<script> alert('ไม่สามารถบันทึกข้อมูลได้')</script>";
} } }?>  

<?php //แสดงรายการผู้ใช้งานพนักงงาน และแก้ไข
$sql2="SELECT *FROM Tadmin";
$result2=mysqli_query($connect,$sql2);
while($row2=mysqli_fetch_array($result2)){
?>
<form action="user.php" method="post">    
<div class="input-group">
    <div class="col-1">
        <input class="form-control form-control-sm"  type="number" name="upADMIN_ID"  value='<?=$row2['ADMIN_ID']?>' readonly>
    </div>
    <div class="col-2">     
        <input class="form-control form-control-sm" type="text"   name="upnameAD"   value='<?=$row2['nameAD']?>'>
    </div>    
    <div class="col-1">     
        <input class="form-control form-control-sm" type="password"   name="uppw"  value='<?=$row2['pw']?>'>
    </div>
    <div class="col-1">     
    <select class="form-select form-select-sm" name="upstatusAD" >
        <?php 
        if($row2['statusAD']=='0'){ $status='ถูกระงับ';}
        elseif($row2['statusAD']=='1'){ $status='ใช้งานได้';}
        ?>
        <option value="<?=$row2['statusAD']?>" selected><?=$status?></option>
        <option value="0">ถูกระงับ</option>
        <option value="1">ใช้งานได้</option>
    </select>  
    </div>
    <div class="col-1">     
    <textarea  class="form-control form-control-sm" rows="1"      name="upnoteAD"><?=$row2['noteAD']?></textarea>
    </div>  
    <button class="btn btn-sm btn-outline-info"     type="submit">  แก้ไข    </button>
    <button class="btn btn-sm btn-outline-danger"   type="reset">   ยกเลิก   </button>
    <a class="btn btn-sm btn-outline-danger" href="user.php?id=<?=$row2['ADMIN_ID']?>">ลบข้อมูล</a>
</div>
</form>  
<?php } ?>


<?php //บันทึกการแก้ไขผู้ใช้งานในฐานข้อมูล
if(isset($_POST["upADMIN_ID"])){
$upADMIN_ID=$_POST["upADMIN_ID"];
$upnameAD=$_POST["upnameAD"];
$uppw=$_POST["uppw"];
$upstatusAD=$_POST["upstatusAD"];
$upnoteAD=$_POST["upnoteAD"];
$uppw=hash('sha512',$uppw);
$sql3="UPDATE Tadmin SET 
ADMIN_ID='$upADMIN_ID',
nameAD='$upnameAD',
pw='$uppw',
statusAD='$upstatusAD',
noteAD='$upnoteAD'
WHERE ADMIN_ID='$upADMIN_ID'";
$result3=mysqli_query($connect,$sql3);
if($result3){
    echo "<script> window.location='user.php'; </script>";
}else{
    echo "<script> alert('ไม่สามารถแก้ไขข้อมูลได้')</script>";
} }

// เรียกลบข้อมูลในฐานข้อมูล
if(isset($_GET['id'])){
$id=$_GET['id'];
$sql4="DELETE FROM Tadmin WHERE ADMIN_ID = '$id'";
$result4=mysqli_query($connect,$sql4);
if($result4){
    echo "<script> window.location='user.php; </script>";
}else{
    echo "<script> alert('ไม่สามารถลบข้อมูลได้')</script>";
} } ?>
    
</body>
</html>
<?php mysqli_close($connect) ?>