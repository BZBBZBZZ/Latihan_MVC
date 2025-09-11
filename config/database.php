<?php
// filepath: config/database.php
$host = 'localhost';
$dbname = 'latihan_mvc';
$username = 'root';
$password = '';

// Koneksi MySQLi (lebih sederhana dari PDO)
$conn = mysqli_connect($host, $username, $password, $dbname);

// Cek koneksi
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
?>