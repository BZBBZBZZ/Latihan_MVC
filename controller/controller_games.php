<?php
include("../model/model_games.php");
session_start();

if (!isset($_SESSION['gameslist'])) {
    $_SESSION['gameslist'] = array();
}

function createGames()
{
    $games = new model_games();
    $games->name = $_POST['inputNama'];
    $games->publisher = $_POST['inputPublisher'];
    $games->genre = $_POST['inputGenre'];
    array_push($_SESSION['gameslist'], $games);
}

function updateGames($gamesID)
{
    $games = $_SESSION['gameslist'][$gamesID]; 
    $games->name = $_POST['inputNama'];
    $games->publisher = $_POST['inputPublisher'];
    $games->genre = $_POST['inputGenre'];
}

function getAllGames()
{
    return $_SESSION['gameslist'];
}

function deleteGames($gamesIndex)
{
    unset($_SESSION['gameslist'][$gamesIndex]);
    $_SESSION['gameslist'] = array_values($_SESSION['gameslist']);
}

function getGamesWithID($gamesID)
{
    return $_SESSION['gameslist'][$gamesID];
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
