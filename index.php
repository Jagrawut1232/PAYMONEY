<!DOCTYPE html>
<html>
<head>
<title>BRIGHT SMILE</title>
<style type="text/css">
BODY {
    width: 550PX;
}

#chart-container {
    width: 100%;
    height: auto;
}
</style>
<script type="text/javascript" src="bootstrap/js/jquery.min.js"></script>
<script type="text/javascript" src="bootstrap/js/Chart.min.js"></script>
<link href="bootstrap/css/bootstrap.min.css" rel="stylesheet">
<script src="bootstrap/js/bootstrap.min.js"></script>
<script src="bootstrap/js/bootstrap.bundle.min.js"></script>
</head>
<body>
     <br>
<div class="container">
    <div class="input-group">
<div><a class="btn btn-outline-secondary" href="paymoneylist.php" role="button">ดูรายจ่าย</a></div>
<div><a class="btn btn-outline-secondary" href="fr_paymoney.php" role="button">ลงบันทึกรายจ่าย</a> </div>
<div class="dropdown">
  <a class="btn btn-secondary dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
    เข้าใช้งาน
  </a>
  <ul class="dropdown-menu">
    <li><a class="dropdown-item" href="login.php">เข้าใช้งาน</a></li>
    <li><a class="dropdown-item" href="loginchange.php">เปลี่ยนรหัส</a></li>
    <li><a class="dropdown-item" href="user.php">เพิ่มผู้ใช้</a></li>
    <li><a class="dropdown-item" href="logout.php">ออกทำงาน</a></li>
  </ul>
</div>
</div>

    <div id="chart-container">
        <canvas id="graphCanvas"></canvas>
       <p> 1=แม่สอด  2=ระยอง   3=พิษณุโลก1   4=พิษณุโลก2</p>
    </div>
    <div id="chart-container">
        <canvas id="graphCanvas1"></canvas>
    </div>

</div>
</body>
</html>
<!-- รายจ่ายแยกตามสาขา -->
<script>
        $(document).ready(function () {
            showGraph();
        });


        function showGraph()
        {
            {
                $.post("data.php",
                function (data)
                {
                    console.log(data);
                     var name = [];
                    var marks = [];

                    for (var i in data) {
                        name.push(data[i].branchPM);
                        marks.push(data[i].PM);
                    }

                    var chartdata = {
                        labels: name,
                        datasets: [
                            {
                                label: 'รายจ่ายแต่ละสาขา',
                                backgroundColor: '#661a00',
                                borderColor: '#46d5f1',
                                hoverBackgroundColor: '#CCCCCC',
                                hoverBorderColor: '#666666',
                                data: marks
                            }
                        ]
                    };

                    var graphTarget = $("#graphCanvas");

                    var barGraph = new Chart(graphTarget, {
                        type: 'bar',
                        data: chartdata
                    });
                });
            }
        }
        </script>
<!-- รายจ่ายแยกตามเดือน -->
<script>
        $(document).ready(function () {
            showGraph1();
        });


        function showGraph1()
        {
            {
                $.post("datamonth.php",
                function (data)
                {
                    console.log(data);
                     var name = [];
                    var marks = [];

                    for (var i in data) {
                        name.push(data[i].monthPM);
                        marks.push(data[i].PMM);
                    }

                    var chartdata = {
                        labels: name,
                        datasets: [
                            {
                                label: 'รายจ่ายแต่ละเดือน',
                                backgroundColor: ' #408000',
                                borderColor: '#334d00',
                                hoverBackgroundColor: '#CCCCCC',
                                hoverBorderColor: '#666666',
                                data: marks
                            }
                        ]
                    };

                    var graphTarget = $("#graphCanvas1");

                    var barGraph = new Chart(graphTarget, {
                        type: 'line',
                        data: chartdata
                    });
                });
            }
        }
        </script>