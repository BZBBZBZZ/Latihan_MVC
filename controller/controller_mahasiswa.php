<?php
include("../model/model_mahasiswa.php");
session_start();



function createMahasiswa()
{
    $mahasiswa = new model_mahasiswa();
    $mahasiswa->name = $_POST['inputNama'];
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
}

function getMahasiswaWithID($mahasiswaID)
{
    return $_SESSION['mahasiswalist'][$mahasiswaID];
}

if (isset($_POST['button_register'])) {
    createMahasiswa();
    header("Location:view_mahasiswa.php");
}

if (!isset($_SESSION['mahasiswalist'])) {
    $_SESSION['mahasiswalist'] = array();
}

if (isset($_GET['deleteID'])) {
    deleteMahasiswa($_GET['deleteID']);
    header("Location:view_mahasiswa.php");
}

if (isset($_POST['button_update'])) {
    updateMahasiswa($_POST['input_id']);
    header("Location:view_mahasiswa.php"); 
}
