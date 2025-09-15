<?php

include("../model/model_mahasiswa.php");
include("../model/model_mahasiswafavoritegame.php");
include("../model/model_games.php");
include("../config/database.php");
session_start();

function getAllGames()
{
    global $conn;
    $sql = "SELECT * FROM games";
    $result = mysqli_query($conn, $sql);
    $games = [];
    
    while ($row = mysqli_fetch_assoc($result)) {
        $game = new model_games();
        $game->id = $row['id'];
        $game->name = $row['name'];
        $game->publisher = $row['publisher'];
        $game->genre = $row['genre'];
        $games[] = $game;
    }
    return $games;
}

function getAllMahasiswaForDropdown()
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

function validateGameExists($gameId)
{
    global $conn;
    $sql = "SELECT COUNT(*) as total FROM games WHERE id=$gameId";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_assoc($result);
    return $row['total'] > 0;
}

function validateMahasiswaExists($mahasiswaId)
{
    global $conn;
    $sql = "SELECT COUNT(*) as total FROM mahasiswa WHERE id=$mahasiswaId";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_assoc($result);
    return $row['total'] > 0;
}

function checkDuplicateFavoriteGame($mahasiswaId, $gameId, $excludeId = null)
{
    global $conn;
    $sql = "SELECT COUNT(*) as total FROM mahasiswa_favorite_game WHERE mahasiswa_id=$mahasiswaId AND game_id=$gameId";
    
    if ($excludeId !== null) {
        $sql .= " AND id != $excludeId";
    }
    
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_assoc($result);
    return $row['total'] > 0;
}

function createMahasiswaFavoriteGame()
{
    global $conn;
    
    if (!validateMahasiswaExists($_POST['inputMahasiswa'])) {
        $_SESSION['error'] = "Mahasiswa yang dipilih tidak valid!";
        return false;
    }

    if (!validateGameExists($_POST['inputGame'])) {
        $_SESSION['error'] = "Game yang dipilih tidak valid!";
        return false;
    }

    if (checkDuplicateFavoriteGame($_POST['inputMahasiswa'], $_POST['inputGame'])) {
        $_SESSION['error'] = "Mahasiswa sudah memiliki game favorit ini!";
        return false;
    }

    $mahasiswaId = $_POST['inputMahasiswa'];
    $gameId = $_POST['inputGame'];
    
    $sql = "INSERT INTO mahasiswa_favorite_game (mahasiswa_id, game_id) VALUES ('$mahasiswaId', '$gameId')";
    mysqli_query($conn, $sql);
    return true;
}

function updateMahasiswaFavoriteGame($favoriteGameID)
{
    global $conn;
    
    if (!validateMahasiswaExists($_POST['inputMahasiswa'])) {
        $_SESSION['error'] = "Mahasiswa yang dipilih tidak valid!";
        return false;
    }

    if (!validateGameExists($_POST['inputGame'])) {
        $_SESSION['error'] = "Game yang dipilih tidak valid!";
        return false;
    }

    if (checkDuplicateFavoriteGame($_POST['inputMahasiswa'], $_POST['inputGame'], $favoriteGameID)) {
        $_SESSION['error'] = "Mahasiswa sudah memiliki game favorit ini!";
        return false;
    }

    $mahasiswaId = $_POST['inputMahasiswa'];
    $gameId = $_POST['inputGame'];
    
    $sql = "UPDATE mahasiswa_favorite_game SET mahasiswa_id='$mahasiswaId', game_id='$gameId' WHERE id=$favoriteGameID";
    mysqli_query($conn, $sql);
    return true;
}

function getAllMahasiswaFavoriteGame()
{
    global $conn;
    $sql = "SELECT mfg.id, m.name as mahasiswa_name, g.name as game_name, mfg.mahasiswa_id, mfg.game_id
            FROM mahasiswa_favorite_game mfg 
            JOIN mahasiswa m ON mfg.mahasiswa_id = m.id 
            JOIN games g ON mfg.game_id = g.id";
    $result = mysqli_query($conn, $sql);
    $favorites = [];
    
    while ($row = mysqli_fetch_assoc($result)) {
        $favorite = new model_mahasiswafavoritegame(); // Menggunakan model yang tepat
        $favorite->id = $row['id'];
        $favorite->mahasiswa_id = $row['mahasiswa_id'];
        $favorite->game_id = $row['game_id'];
        $favorite->mahasiswa_name = $row['mahasiswa_name'];
        $favorite->game_name = $row['game_name'];
        $favorites[] = $favorite;
    }
    return $favorites;
}

function deleteMahasiswaFavoriteGame($favoriteGameID)
{
    global $conn;
    $sql = "DELETE FROM mahasiswa_favorite_game WHERE id=$favoriteGameID";
    mysqli_query($conn, $sql);
}

function getMahasiswaFavoriteGameWithID($favoriteGameID)
{
    global $conn;
    $sql = "SELECT mfg.id, mfg.mahasiswa_id, mfg.game_id, m.name as mahasiswa_name, g.name as game_name
            FROM mahasiswa_favorite_game mfg 
            JOIN mahasiswa m ON mfg.mahasiswa_id = m.id 
            JOIN games g ON mfg.game_id = g.id 
            WHERE mfg.id=$favoriteGameID";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_assoc($result);
    
    if ($row) {
        $favorite = new model_mahasiswafavoritegame(); // Menggunakan model yang tepat
        $favorite->id = $row['id'];
        $favorite->mahasiswa_id = $row['mahasiswa_id'];
        $favorite->game_id = $row['game_id'];
        $favorite->mahasiswa_name = $row['mahasiswa_name'];
        $favorite->game_name = $row['game_name'];
        return $favorite;
    }
    return null;
}

// Handle POST requests
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
?>