<?php
include_once 'konfig_koneksi_db.php';   // Needed because functions.php is not included

$mysqli_ex = new mysqli(HOST, USER, PASSWORD, DATABASE_EX);
if ($mysqli_ex->connect_error) {
    header("Location: ../error.php?err=Unable to connect to MySQL DB EX");
    exit();
}

