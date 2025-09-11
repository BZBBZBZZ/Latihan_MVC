<?php
include("../model/model_mahasiswa.php");
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

function createMahasiswa()
{
    global $conn;
    $nama = $_POST['inputNama'];
    $usia = $_POST['inputUsia'];
    $jurusan = $_POST['inputJurusan'];
    
    $sql = "INSERT INTO mahasiswa (name, age, major) VALUES ('$nama', '$usia', '$jurusan')";
    mysqli_query($conn, $sql);
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

function updateMahasiswa($mahasiswaID)
{
    global $conn;
    $nama = $_POST['inputNama'];
    $usia = $_POST['inputUsia'];
    $jurusan = $_POST['inputJurusan'];
    
    $sql = "UPDATE mahasiswa SET name='$nama', age='$usia', major='$jurusan' WHERE id=$mahasiswaID";
    mysqli_query($conn, $sql);
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
        $favorite = new model_mahasiswa();
        $favorite->id = $row['id'];
        $favorite->name = $row['mahasiswa_name'];
        $favorite->game_name = $row['game_name'];
        $favorite->game_id = $row['game_id'];
        $favorites[] = $favorite;
    }
    return $favorites;
}

function deleteMahasiswa($mahasiswaID)
{
    global $conn;
    $sql = "DELETE FROM mahasiswa WHERE id=$mahasiswaID";
    mysqli_query($conn, $sql);
}

function deleteMahasiswaFavoriteGame($favoriteGameID)
{
    global $conn;
    $sql = "DELETE FROM mahasiswa_favorite_game WHERE id=$favoriteGameID";
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
        $favorite = new model_mahasiswa();
        $favorite->id = $row['id'];
        $favorite->name = $row['mahasiswa_name'];
        $favorite->game_name = $row['game_name'];
        $favorite->game_id = $row['game_id'];
        return $favorite;
    }
    return null;
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
?>