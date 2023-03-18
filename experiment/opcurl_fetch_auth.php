<?php
include_once 'koneksi_db.php';

$extab = "extab";
$extab2 = "extab2";


$exq1 = "REPLACE INTO " . $extab2 . " SELECT * FROM " . $extab . "";
mysqli_query($mysqli_ex,$exq1);


mysqli_close($mysqli_ex);
?>