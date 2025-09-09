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
      <div class="card-body">

        <h1>New Mahasiswa</h1>
        <form method="POST" action="controller_mahasiswa.php">
          <div class="form-row">
          </div>
          <div class="form-group">
            <label for="inputName">Nama</label>
            <input type="text" class="form-control" name="inputName" placeholder="Masukkan Nama">
          </div>
          <div class="form-group">
            <label for="inputUsia">Usia</label>
            <input type="text" class="form-control" name="inputUsia" placeholder="Masukkan Usia">
          </div>
          <div class="form-group">
            <label for="inputJurusan">Jurusan</label>
            <input type="text" class="form-control" name="inputJurusan" placeholder="Masukkan Jurusan">
          </div>
          <button name="buttonadd" type="submit" class="btn btn-primary">Add</button>
        </form>
      </div>
</body>

</html>