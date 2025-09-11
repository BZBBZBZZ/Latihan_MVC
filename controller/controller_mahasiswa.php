<?php
include("../model/model_mahasiswa.php");
include("../model/model_games.php");
session_start();

if (!isset($_SESSION['mahasiswalist'])) {
    $_SESSION['mahasiswalist'] = array();
}

if (!isset($_SESSION['mahasiswafavoritegamelist'])) {
    $_SESSION['mahasiswafavoritegamelist'] = array();
}

if (!isset($_SESSION['gameslist'])) {
    $_SESSION['gameslist'] = array();
}

function getAllGames()
{
    return $_SESSION['gameslist'];
}

function getAllMahasiswaForDropdown()
{
    return $_SESSION['mahasiswalist'];
}

function validateGameExists($gameName)
{
    if (empty($gameName)) {
        return false;
    }

    foreach ($_SESSION['gameslist'] as $game) {
        if ($game->name === $gameName) {
            return true;
        }
    }
    return false;
}

function validateMahasiswaExists($mahasiswaName)
{
    if (empty($mahasiswaName)) {
        return false;
    }

    foreach ($_SESSION['mahasiswalist'] as $mahasiswa) {
        if ($mahasiswa->name === $mahasiswaName) {
            return true;
        }
    }
    return false;
}

function checkDuplicateFavoriteGame($mahasiswaName, $gameName, $excludeIndex = null)
{
    foreach ($_SESSION['mahasiswafavoritegamelist'] as $index => $favGame) {
        if ($excludeIndex !== null && $index == $excludeIndex) {
            continue;
        }

        if ($favGame->name === $mahasiswaName && $favGame->game_name === $gameName) {
            return true; 
        }
    }
    return false;
}

function createMahasiswa()
{
    $mahasiswa = new model_mahasiswa();
    $mahasiswa->name = $_POST['inputNama'];
    $mahasiswa->age = $_POST['inputUsia'];
    $mahasiswa->major = $_POST['inputJurusan'];
    array_push($_SESSION['mahasiswalist'], $mahasiswa);
}

function createMahasiswaFavoriteGame()
{
    if (!validateMahasiswaExists($_POST['inputNama'])) {
        $_SESSION['error'] = "Mahasiswa yang dipilih tidak valid atau tidak ada dalam daftar mahasiswa!";
        return false;
    }

    if (!validateGameExists($_POST['inputGame'])) {
        $_SESSION['error'] = "Game yang dipilih tidak valid atau tidak ada dalam daftar games!";
        return false;
    }

    if (checkDuplicateFavoriteGame($_POST['inputNama'], $_POST['inputGame'])) {
        $_SESSION['error'] = "Mahasiswa " . $_POST['inputNama'] . " sudah memiliki game favorit " . $_POST['inputGame'] . "!";
        return false;
    }

    $mahasiswa = new model_mahasiswa();
    $mahasiswa->name = $_POST['inputNama'];
    $mahasiswa->game_name = $_POST['inputGame'];
    array_push($_SESSION['mahasiswafavoritegamelist'], $mahasiswa);
    return true;
}

function updateMahasiswa($mahasiswaID)
{
    $mahasiswa = $_SESSION['mahasiswalist'][$mahasiswaID];
    $mahasiswa->name = $_POST['inputNama'];
    $mahasiswa->age = $_POST['inputUsia'];
    $mahasiswa->major = $_POST['inputJurusan'];
}

function updateMahasiswaFavoriteGame($mahasiswaID)
{
    if (!validateMahasiswaExists($_POST['inputNama'])) {
        $_SESSION['error'] = "Mahasiswa yang dipilih tidak valid atau tidak ada dalam daftar mahasiswa!";
        return false;
    }

    if (!validateGameExists($_POST['inputGame'])) {
        $_SESSION['error'] = "Game yang dipilih tidak valid atau tidak ada dalam daftar games!";
        return false;
    }

    if (checkDuplicateFavoriteGame($_POST['inputNama'], $_POST['inputGame'], $mahasiswaID)) {
        $_SESSION['error'] = "Mahasiswa " . $_POST['inputNama'] . " sudah memiliki game favorit " . $_POST['inputGame'] . "!";
        return false;
    }

    $mahasiswa = $_SESSION['mahasiswafavoritegamelist'][$mahasiswaID];
    $mahasiswa->name = $_POST['inputNama'];
    $mahasiswa->game_name = $_POST['inputGame'];
    return true;
}

function getAllMahasiswa()
{
    return $_SESSION['mahasiswalist'];
}

function getAllMahasiswaFavoriteGame()
{
    return $_SESSION['mahasiswafavoritegamelist'];
}

function deleteMahasiswa($mahasiswaIndex)
{
    unset($_SESSION['mahasiswalist'][$mahasiswaIndex]);
    $_SESSION['mahasiswalist'] = array_values($_SESSION['mahasiswalist']);
}

function deleteMahasiswaFavoriteGame($mahasiswaIndex)
{
    unset($_SESSION['mahasiswafavoritegamelist'][$mahasiswaIndex]);
    $_SESSION['mahasiswafavoritegamelist'] = array_values($_SESSION['mahasiswafavoritegamelist']);
}

function getMahasiswaWithID($mahasiswaID)
{
    return $_SESSION['mahasiswalist'][$mahasiswaID];
}

function getMahasiswaFavoriteGameWithID($mahasiswaID)
{
    return $_SESSION['mahasiswafavoritegamelist'][$mahasiswaID];
}

if (isset($_POST['buttonaddfavgame'])) {
    if (createMahasiswaFavoriteGame()) {
        header("Location: ../view/view_mahasiswafavoritegame.php");
        exit();
    } else {
        header("Location: ../view/view_addmahasiswafavoritegame.php");
        exit();
    }
}

if (isset($_POST['buttoneditfavgame'])) {
    if (updateMahasiswaFavoriteGame($_POST['input_id'])) {
        header("Location: ../view/view_mahasiswafavoritegame.php");
        exit();
    } else {
        header("Location: ../view/view_editmahasiswafavoritegame.php?editID=" . $_POST['input_id']);
        exit();
    }
}

if (isset($_GET['deleteFavGameID'])) {
    deleteMahasiswaFavoriteGame($_GET['deleteFavGameID']);
    header("Location: ../view/view_mahasiswafavoritegame.php");
    exit();
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
