<?php
include("model_member.php");
session_start();

if (!isset($_SESSION['mahasiswalist'])) {
    $_SESSION['mahasiswalist'] = array();
}

function createMahasiswa(){
    $mahasiswa = new model_mahasiswa();
    $mahasiswa->name = $_POST['inputName'];
    $mahasiswa->age = $_POST['inputAge'];
    $mahasiswa->major = $_POST['inputMajor'];
    array_push($_SESSION['mahasiswalist'],$mahasiswa);
}
?>
