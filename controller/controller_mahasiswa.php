<?php
include("../model/model_mahasiswa.php");
include("../config/database.php");
session_start();

function createMahasiswa()
{
    global $conn;
    $nama = $_POST['inputNama'];
    $usia = $_POST['inputUsia'];
    $jurusan = $_POST['inputJurusan'];
    
    $sql = "INSERT INTO mahasiswa (name, age, major) VALUES ('$nama', '$usia', '$jurusan')";
    mysqli_query($conn, $sql);
}

function updateMahasiswa($mahasiswaID)
{
    global $conn;
    $nama = $_POST['inputNama'];
    $usia = $_POST['inputUsia'];
    $jurusan = $_POST['inputJurusan'];
    
    $sql = "UPDATE mahasiswa SET name='$nama', age='$usia', major='$jurusan' WHERE id=$mahasiswaID";
    mysqli_query($conn, $sql);
}

function getAllMahasiswa()
{
    global $conn;
    $sql = "SELECT * FROM mahasiswa";
    $result = mysqli_query($conn, $sql);
    $mahasiswa = [];
    
    while ($row = mysqli_fetch_assoc($result)) {
        $mhs = new model_mahasiswa();
        $mhs->id = $row['id'];
        $mhs->name = $row['name'];
        $mhs->age = $row['age'];
        $mhs->major = $row['major'];
        $mahasiswa[] = $mhs;
    }
    return $mahasiswa;
}

function deleteMahasiswa($mahasiswaID)
{
    global $conn;
    $sql = "DELETE FROM mahasiswa WHERE id=$mahasiswaID";
    mysqli_query($conn, $sql);
}

function getMahasiswaWithID($mahasiswaID)
{
    global $conn;
    $sql = "SELECT * FROM mahasiswa WHERE id=$mahasiswaID";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_assoc($result);
    
    if ($row) {
        $mahasiswa = new model_mahasiswa();
        $mahasiswa->id = $row['id'];
        $mahasiswa->name = $row['name'];
        $mahasiswa->age = $row['age'];
        $mahasiswa->major = $row['major'];
        return $mahasiswa;
    }
    return null;
}

// Handle POST requests
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