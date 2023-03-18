<?php
include_once($_SERVER["DOCUMENT_ROOT"] . "/regional7/konfig_koneksi_db.php");

$mysqli = new mysqli(HOST, USER, PASSWORD, DATABASE_GGN);
if ($mysqli->connect_error) {
    header("Location: ../error.php?err=Unable to connect to MySQL DB GGN");
    exit();
}
$mysqli_history_nona = new mysqli(HOST, USER, PASSWORD, DATABASE_HISTORY_NONA);
if ($mysqli_history_nona->connect_error) {
    header("Location: ../error.php?err=Unable to connect to MySQL DB NONA");
    exit();
}
$mysqli_history_rock = new mysqli(HOST, USER, PASSWORD, DATABASE_HISTORY_ROCK);
if ($mysqli_history_rock->connect_error) {
    header("Location: ../error.php?err=Unable to connect to MySQL DB ROCK");
    exit();
}
$mysqli_point = new mysqli(HOST, USER, PASSWORD, DATABASE_POINT);
if ($mysqli_point->connect_error) {
    header("Location: ../error.php?err=Unable to connect to MySQL DB POINT");
    exit();
}