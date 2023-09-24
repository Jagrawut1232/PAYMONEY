<?php 
session_start();
if(!isset($_SESSION['nameAD']))
header("location:login.php");
$ADMIN_ID=$_SESSION['ADMIN_ID'];
include "dbconnect.php"; ?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>BRIGHT SMILE</title>
  <link href="bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <script src="bootstrap/js/bootstrap.min.js"></script>
</head>
<body>

<div class="container col-sm-12"> 
  <h4>รายงานรายจ่ายรวม</h4>   
  <?php // ฟอร์มเลือกข้อมุูลตามช่วงเวลาที่ต้องการดู และพนักงานที่ต้องการดู  ?>
  <form action="paymoneylist.php" method="post" enctype="multipart/form-data">
    <div class="input-group col-4"> 
      <span class="input-group-text">เลือกเดือน</span>
      <input class="form-control form-control-sm" type="month" name="month"> 
      <select class="form-select" name="branch" >
            <option value="" selected>เลือกสาขา</option>
            <option value="1">แม่สอด</option>
            <option value="2">ระยอง</option>
            <option value="3">พิษณุโลก1</option>
            <option value="4">พิษณุโลก2</option>
        </select>   
      <button class="btn btn-outline-success" name="go"type="submit">แสดง</button> 
      <button class="btn btn-outline-danger" type="reset">ยกเลิก</button>
      <a class="btn btn-outline-secondary" href="fr_paymoney.php" role="button">ลงบันทึกรายจ่าย</a>
      <a class="btn btn-outline-secondary" href="index.php" role="button">กลับหน้าหลัก</a>
    </div>
  </form>
      <?php // โค้ดกำหนดเวลาต้นเดือนและปลายเดือน ของเดือนที่ถูกเลือก 
      $month=@$_POST['month'];
      if($month!=""){
      $MY=explode('-',$month);
      $Y=$MY[0];  // กำหนดเดือน
      $M=$MY[1];  // กำหนดปี
      }else{      // ถ้าไม่เลือกเดือนให้แสดงข้อมูลในเดือนปัจจุบัน
          $today=date("Y-m-d"); 
          $t=explode('-',$today);
          $Y=$t[0];
          $M=$t[1];
      }
          $d1=mktime(0,0,0,$M,1,$Y);
          $datestart=date("Y-m-d",$d1);
        $a=$Y%4;
        switch($M){  //กำหนดวันสิ้นเดือนแต่ละเดือน
        case "1":$d2=mktime(0,0,0,$M,31,$Y); break;
        case "3":$d2=mktime(0,0,0,$M,31,$Y); break;
        case "4":$d2=mktime(0,0,0,$M,30,$Y); break;
        case "5":$d2=mktime(0,0,0,$M,31,$Y); break;
        case "6":$d2=mktime(0,0,0,$M,30,$Y); break;
        case "7":$d2=mktime(0,0,0,$M,31,$Y); break;
        case "8":$d2=mktime(0,0,0,$M,31,$Y); break;
        case "9":$d2=mktime(0,0,0,$M,30,$Y); break;
        case "10":$d2=mktime(0,0,0,$M,31,$Y); break;
        case "11":$d2=mktime(0,0,0,$M,30,$Y); break;
        case "12":$d2=mktime(0,0,0,$M,31,$Y); break;
        case "2":  //กำหนดวันสิ้นเดือนกุมภาพันธ์
          if($a=0){
          $d2=mktime(0,0,0,$M,29,$Y);
        }else{
          $d2=mktime(0,0,0,$M,28,$Y);
        }break;
        }
          $dateend=date("Y-m-d",$d2); ?>
          เดือน
         <?php 
          if($M=='01'){ echo "มกราคม";
          }elseif($M=='02'){ echo "กุมภาพันธ์";
          }elseif($M=='03'){ echo "มีนาคม";
          }elseif($M=='04'){ echo "เมษายน";
          }elseif($M=='05'){ echo "พฤษภาคม";
          }elseif($M=='06'){ echo "มิถุนายน";
          }elseif($M=='07'){ echo "กรกฎาคม";
          }elseif($M=='08'){ echo "สิงหาคม";
          }elseif($M=='09'){ echo "กันยายน";
          }elseif($M=='10'){ echo "ตุลาคม";
          }elseif($M=='11'){ echo "พฤศจิกายน";
          }elseif($M=='12'){ echo "ธันวาคม"; 
          }?> <?=$Y+543?></th>
      
 <br>
<table class="table table-sm">
<tr>
  <th>ลำดับ</th> 
  <th>วันที่จ่าย</th>
  <th>รายการจ่าย</th> 
  <td align=end><b>จำนวน</b></td> 
  <th>จ่ายให้</th>
  <th>เลขที่เอกสาร</th>       
  <th>เลขที่สลิป</th>              
  <th>สาขา</th>
  <th>แก้ไข</th> 
  <th>ลบ</th> 
</tr>    
<?php
$branch=@$_POST['branch'];
if($branch!=""){
  $sql1="SELECT * FROM Tpaymoney 
  WHERE branchPM='$branch' 
  AND datePM BETWEEN '$datestart' AND '$dateend'";
}else{
  $sql1="SELECT * FROM Tpaymoney 
  WHERE datePM BETWEEN '$datestart' AND '$dateend'"; 
}
$result1=mysqli_query($connect,$sql1);
$TOTAL=0;
while($row1=mysqli_fetch_array($result1)){
$TOTAL=$TOTAL+$row1['pPM'];?>
<tr>
<form action="paymoneylist.php" method="post" enctype="multipart/form-data">
<input class="form-control form-control-sm" type="date" name="PM_ID" value="hello" hidden>
  <td><?=$row1['PM_ID']?></td> 
  <td><?=$row1['datePM']?></td>
  <td><?=$row1['listPM']?></td> 
  <td align=end><?=$row1['pPM']?></td> 
  <td><?=$row1['whoPM']?> </td>    
  <td><?=$row1['invoicePM']?> </td>       
  <td><?=$row1['slipPM']?> </td> 
  <?php
  if($row1['branchPM']==1){ $branch='แม่สอด';}
  elseif($row1['branchPM']==2){ $branch='ระยอง';}
  elseif($row1['branchPM']==3){ $branch='พิษณุโลก1';}
  elseif($row1['branchPM']==4){ $branch='พิษณุโลก2';}
  ?>               
  <td><?=$branch?> </td>
  <td><a class="btn btn-sm btn-outline-secondary" href="editpaymoney.php?id=<?=$row1['PM_ID']?>" role="button">แก้ไข/ดู</a></td> 
  <td><a class="btn btn-sm btn-outline-danger" href="paymoneylist.php?id=<?=$row1['PM_ID']?>" role="button">ลบ</a></td>
</tr>     
<?php } ?>
<tr>
<td align=end colspan=3>จำนวนรวม</td>        
<td align=end><b><?=$TOTAL?></b>บาท</td>
<td colspan=6></td>
</tr>
</table>
</div>
</body>
</html> 
<?php
  if(isset($_GET['id'])){
    $id=$_GET['id'];
    $sql2="DELETE FROM Tpaymoney WHERE PM_ID = '$id'";
    $result2=mysqli_query($connect,$sql2);
  } ?>
<?php mysqli_close($connect); ?>