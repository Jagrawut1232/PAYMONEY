<?php
header('Content-Type: application/json');

$conn = mysqli_connect("localhost","root","","paymoney");

$sqlQuery = "SELECT monthPM,sum(pPM) as 'PMM' FROM Tpaymoney GROUP BY monthPM ORDER BY monthPM";

$result = mysqli_query($conn,$sqlQuery);

$data = array();
foreach ($result as $row) {
	$data[] = $row;
}

mysqli_close($conn);

echo json_encode($data);
?>