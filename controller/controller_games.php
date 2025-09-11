<?php
include("../model/model_games.php");
include("../config/database.php");
session_start();

function createGames()
{
    global $conn;
    $nama = $_POST['inputNama'];
    $publisher = $_POST['inputPublisher'];
    $genre = $_POST['inputGenre'];
    
    $sql = "INSERT INTO games (name, publisher, genre) VALUES ('$nama', '$publisher', '$genre')";
    mysqli_query($conn, $sql);
}

function updateGames($gamesID)
{
    global $conn;
    $nama = $_POST['inputNama'];
    $publisher = $_POST['inputPublisher'];
    $genre = $_POST['inputGenre'];
    
    $sql = "UPDATE games SET name='$nama', publisher='$publisher', genre='$genre' WHERE id=$gamesID";
    mysqli_query($conn, $sql);
}

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

function deleteGames($gamesID)
{
    global $conn;
    $sql = "DELETE FROM games WHERE id=$gamesID";
    mysqli_query($conn, $sql);
}

function getGamesWithID($gamesID)
{
    global $conn;
    $sql = "SELECT * FROM games WHERE id=$gamesID";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_assoc($result);
    
    if ($row) {
        $game = new model_games();
        $game->id = $row['id'];
        $game->name = $row['name'];
        $game->publisher = $row['publisher'];
        $game->genre = $row['genre'];
        return $game;
    }
    return null;
}

if (isset($_POST['buttonadd'])) {
    createGames();
    header("Location: ../view/view_games.php");
    exit();
}

if (isset($_GET['deleteID'])) {
    deleteGames($_GET['deleteID']);
    header("Location: ../view/view_games.php");
    exit();
}

if (isset($_POST['buttonedit'])) {
    updateGames($_POST['input_id']);
    header("Location: ../view/view_games.php"); 
    exit();
}
?>