<?php
require("../controller/controller_games.php");
if (isset($_GET["editID"])) {
  $games_id = $_GET["editID"];
  $games = getGamesWithID($games_id);
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css"
    integrity="sha384-xOolHFLEh07PJGoPkLv1IbcEPTNtaed2xpHsD9ESMhqIYd0nLMwNLD69Npy4HI+N" crossorigin="anonymous">
  <title>Document</title>
</head>

<body>
  <div class="container p-3">
    <div class="card text-center">
      <div class="card-header">
        <ul class="nav nav-tabs card-header-tabs">
          <li class="nav-item">
            <a class="nav-link " href="view_mahasiswa.php">Mahasiswa</a>
          </li>
          <li class="nav-item">
            <a class="nav-link " href="view_addmahasiswa.php">New Mahasiswa</a>
          </li>
          <li class="nav-item">
            <a class="nav-link " href="view_games.php">Games</a>
          </li>
          <li class="nav-item">
            <a class="nav-link " href="view_addgames.php">New Games</a>
          </li>
          <li class="nav-item">
            <a class="nav-link " href="view_mahasiswafavoritegame.php">Mahasiswa Favorite Game</a>
          </li>
          <li class="nav-item">
            <a class="nav-link " href="view_addmahasiswafavoritegame.php">New Mahasiswa Favorite Game</a>
          </li>
        </ul>
      </div>
      <div class="card-body">

        <h1>Edit Games</h1>
        <form method="POST" action="../controller/controller_games.php">
          <div class="form-row">
          </div>
          <div class="form-group">
            <label for="inputNama">Nama</label>
            <input type="text" class="form-control" name="inputNama" value="<?= $games->name ?>">
          </div>
          <div class="form-group">
            <label for="inputPublisher">Publisher</label>
            <input type="text" class="form-control" name="inputPublisher" value="<?= $games->publisher ?>">
          </div>
          <div class="form-group">
            <label for="inputGenre">Genre</label>
            <input type="text" class="form-control" name="inputGenre" value="<?= $games->genre ?>">
          </div>
          <input type="hidden" name="input_id" value="<?= $games_id ?>">
          <button name="buttonedit" type="submit" class="btn btn-primary">Edit</button>
        </form>
      </div>
</body>

</html>