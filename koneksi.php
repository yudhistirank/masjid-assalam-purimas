<?php
$host = "localhost";
$user = "root";
$pass = "";
$db = "lapkeumasjid";

$koneksi = mysqli_connect($host, $user, $pass, $db);

if (!$koneksi) {
  die("Tidak bisa terkoneksi ke database: " . mysqli_connect_error());
}
?>