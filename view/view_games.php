<?php require("../controller/controller_games.php"); ?>

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
      <div class="card-body"></div>
      <div class="container p-3">
        <h1>Games</h1>

        <table class="table">
          <thead class="thead-dark">
            <tr>
              <th scope="col">No</th>
              <th scope="col">Nama</th>
              <th scope="col">Publisher</th>
              <th scope="col">Genre</th>
              <th scope="col">Action</th>
            </tr>
          </thead>
          <tbody>
            <?php
            $counter = 0;
            $allgames = getAllGames();
            foreach ($allgames as $index => $game) {
              $counter++;
            ?>

              <tr>
                <th scope="row"><?= $counter ?></th>
                <td><?php echo $game->name; ?></td>
                <td><?php echo $game->publisher; ?></td>
                <td><?php echo $game->genre; ?></td>
                <td>
                  <a href="../view/view_editgames.php?editID=<?= $index ?>" class="btn btn-warning">Edit</a>
                  <a href="../controller/controller_games.php?deleteID=<?= $index ?>" class="btn btn-danger">Delete</a>
                </td>
              </tr>

            <?php
            }
            ?>
          </tbody>
        </table>
      </div>
    </div>
</body>

</html>