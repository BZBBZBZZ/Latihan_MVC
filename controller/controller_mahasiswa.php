<?php
include("../model/model_mahasiswa.php");
session_start();

// Inisialisasi session array di awal
if (!isset($_SESSION['mahasiswalist'])) {
    $_SESSION['mahasiswalist'] = array();
}

function createMahasiswa()
{
    $mahasiswa = new model_mahasiswa();
    $mahasiswa->name = $_POST['inputName'];
    $mahasiswa->age = $_POST['inputUsia'];
    $mahasiswa->major = $_POST['inputJurusan'];
    array_push($_SESSION['mahasiswalist'], $mahasiswa);
}

function updateMahasiswa($mahasiswaID)
{
    $mahasiswa = $_SESSION['mahasiswalist'][$mahasiswaID]; // ambil data dengan index tertentu
    $mahasiswa->name = $_POST['inputNama'];
    $mahasiswa->age = $_POST['inputUsia'];
    $mahasiswa->major = $_POST['inputJurusan'];
}

function getAllMahasiswa()
{
    return $_SESSION['mahasiswalist'];
}

function deleteMahasiswa($mahasiswaIndex)
{
    unset($_SESSION['mahasiswalist'][$mahasiswaIndex]);
    // Re-index array setelah delete
    $_SESSION['mahasiswalist'] = array_values($_SESSION['mahasiswalist']);
}

function getMahasiswaWithID($mahasiswaID)
{
    return $_SESSION['mahasiswalist'][$mahasiswaID];
}

if (isset($_POST['buttonadd'])) {
    createMahasiswa();
    header("Location: ../view/view_mahasiswa.php");
    exit();
}

if (isset($_GET['deleteID'])) {
    deleteMahasiswa($_GET['deleteID']);
    header("Location: ../view/view_mahasiswa.php");
    exit();
}

if (isset($_POST['buttonedit'])) {
    updateMahasiswa($_POST['input_id']);
    header("Location: ../view/view_mahasiswa.php"); 
    exit();
}
?>
