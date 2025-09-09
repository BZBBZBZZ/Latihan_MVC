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
        </ul>
      </div>
      <div class="card-body"></div>
      <div class="container p-3">
        <h1>Mahasiswa</h1>

        <table class="table">
          <thead class="thead-dark">
            <tr>
              <th scope="col">No</th>
              <th scope="col">Nama</th>
              <th scope="col">Usia</th>
              <th scope="col">Jurusan</th>
              <th scope="col">Action</th>
            </tr>
          </thead>
          <tbody>
            <?php
            $counter = 0;
            $allmembers = getAllMahasiswa();
            foreach ($allmembers as $index => $member) {
              $counter++;
              ?>

              <tr>
                <th scope="row"><?= $counter ?></th>
                <td><?php echo $member->name; ?></td>
                <td><?php echo $member->age; ?></td>
                <td><?php echo $member->major; ?></td>
                <td>
                  <a href="../view/view_editmahasiswa.php?id=<?= $index ?>" class="btn btn-warning">Edit</a>
                  <a href="../controller/controller_mahasiswa.php?deleteID=<?= $index ?>" class="btn btn-danger">Delete</a>
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