<?php require("../controller/controller_mahasiswafavoritegame.php"); ?>

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
                        <a class="nav-link" href="view_mahasiswa.php">Mahasiswa</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="view_addmahasiswa.php">New Mahasiswa</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="view_games.php">Games</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="view_addgames.php">New Games</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" href="view_mahasiswafavoritegame.php">Mahasiswa Favorite Game</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="view_addmahasiswafavoritegame.php">New Mahasiswa Favorite Game</a>
                    </li>
                </ul>
            </div>
            <div class="card-body"></div>
            <div class="container p-3">
                <h1>Mahasiswa Favorite Game</h1>

                <table class="table">
                    <thead class="thead-dark">
                        <tr>
                            <th scope="col">No</th>
                            <th scope="col">Nama Mahasiswa</th>
                            <th scope="col">Game Favorit</th>
                            <th scope="col">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $counter = 0;
                        $allmembers = getAllMahasiswaFavoriteGame();
                        foreach ($allmembers as $member) {
                            $counter++;
                        ?>

                            <tr>
                                <th scope="row"><?= $counter ?></th>
                                <td><?php echo $member->mahasiswa_name; ?></td>
                                <td><?php echo $member->game_name; ?></td>
                                <td>
                                    <a href="../view/view_editmahasiswafavoritegame.php?editID=<?= $member->id ?>" class="btn btn-warning">Edit</a>
                                    <a href="../controller/controller_mahasiswafavoritegame.php?deleteFavGameID=<?= $member->id ?>" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this favorite game?')">Delete</a>
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