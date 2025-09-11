<?php require("../controller/controller_mahasiswa.php"); ?>

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
            <a class="nav-link active" href="view_mahasiswa.php">Mahasiswa</a>
          </li>
          <li class="nav-item">
            <a class="nav-link active" href="view_addmahasiswa.php">New Mahasiswa</a>
          </li>
          <li class="nav-item">
            <a class="nav-link active" href="view_games.php">Games</a>
          </li>
          <li class="nav-item">
            <a class="nav-link active" href="view_addgames.php">New Games</a>
          </li>
          <li class="nav-item">
            <a class="nav-link active" href="view_mahasiswafavoritegame.php">Mahasiswa Favorite Game</a>
          </li>
          <li class="nav-item">
            <a class="nav-link active" href="view_addmahasiswafavoritegame.php">New Mahasiswa Favorite Game</a>
          </li>
        </ul>
      </div>
      <div class="card-body">

        <h1>New Mahasiswa Favorite Game</h1>

        <?php if (isset($_SESSION['error'])): ?>
          <div class="alert alert-danger">
            <?= $_SESSION['error'] ?>
          </div>
          <?php unset($_SESSION['error']); ?>
        <?php endif; ?>

        <form method="POST" action="../controller/controller_mahasiswa.php">
          <div class="form-group">
            <label for="inputNama">Nama Mahasiswa</label>
            <select class="form-control" name="inputNama" required>
              <option value="">Pilih Mahasiswa</option>
              <?php
              $allmahasiswa = getAllMahasiswaForDropdown();
              foreach ($allmahasiswa as $mahasiswa) {
              ?>
                <option value="<?= $mahasiswa->name ?>"><?= $mahasiswa->name ?></option>
              <?php
              }
              ?>
            </select>
          </div>
          <div class="form-group">
            <label for="inputGame">Game Favorit</label>
            <select class="form-control" name="inputGame" required>
              <option value="">Pilih Game</option>
              <?php
              $allgames = getAllGames();
              foreach ($allgames as $game) {
              ?>
                <option value="<?= $game->name ?>"><?= $game->name ?></option>
              <?php
              }
              ?>
            </select>
          </div>
          <button name="buttonaddfavgame" type="submit" class="btn btn-primary">Add</button>
        </form>
      </div>
    </div>
  </div>
</body>

</html>