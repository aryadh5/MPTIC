<?php require 'function.php';
session_start();
if (!isset($_SESSION["login"])) {
    header("location:login.php");
    exit;
}

$produk = "SELECT COLUMN_TYPE AS num FROM INFORMATION_SCHEMA.COLUMNS WHERE COLUMN_NAME = 'jenis'";
$produk1 = query("SELECT * FROM produk");
$jslimit = count($produk1);
$enum = enum($produk);
$limit = count($enum);
$i = 0;
$x = 1;
$j = 0;
if (isset($_POST["submit"])) {

    // $nama = $_POST["nama"];
    // if (empty($nama)){
    //     echo "<script>
    //     alert('Nama tidak boleh kosong');
    //     document.location.href='admin.php';
    //     </script>";
    //     die;
    // }
    // diganti menjadi 'required'

    if (tambahproduk($_POST) > 0) {
        echo "<script>
            alert('Produk baru berhasil di tambah');
            document.location.href='admin.php';
            </script>";
    } else {
        echo "<script>
            alert('Produk gagal di tambahkan');
            document.location.href='admin.php';
            </script>";
    }
}
    ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
</head>
<body>
<div class="container text-center">
    <div class="row"> <!-- Bagian tambah data -->
        <div class="col">
            <h1 style="display: inline;">Tambah</h1>
            <a class="btn btn-dark" style="float: right;" href="logout.php">Logout</a>

            <form action="" method="post" enctype="multipart/form-data">
                <div class="form-group py-2">
                    <input class="form-control" type="text" id="nama" name="nama" placeholder="Nama" required>
                    <input class="form-control" type="text" id="harga" name="harga" placeholder="Harga" required>
                    <select class="form-select" aria-label="Default select example" name="jenis" id="jenis">
                    <?php for($i; $i<$limit; $i++){?>
                    <option value="<?= $enum[$i];?>"><?= $enum[$i];?></option>
                <?php } ?>
                    </select>

                    <input class="form-control" type="file" id="gambaru" name="gambar" placeholder="Gambar">
                    <input class="form-control" type="textarea" id="deskripsi" name="deskripsi" placeholder="Deskripsi" required>
                    <button class="btn btn-dark" type="submit" name="submit">Submit</button>
                </div>
            </form>
        </div>
    </div>
    <table class="table">  <!-- Bagian tampil data -->
    <thead>
        <tr>
        <th scope="col">No</th>
        <th scope="col">Nama</th>
        <th scope="col">Jenis</th>
        <th scope="col">Harga</th>
        <th scope="col">Deskripsi</th>
        <th scope="col">Gambar</th>
        <th></th>
        </tr>
    </thead>
    <tbody>
        <?php foreach($produk1 as $row) :?>
        <tr>
        <td><?= $x++; ?></td>
        <td><?= $row["nama"]; ?></td>
        <td><?= $row["jenis"]; ?></td>
        <td><?= $row["harga"]; ?></td>
        <td><?= $row["deskripsi"]; ?></td>
        <td><img id="gambar<?php $j++; ?>" src="img/<?= $row["gambar"]; ?>" class="img-thumbnail" style="width:15%;"></td>
        <td><a href="editproduk.php?id=<?= $row["produkid"]; ?>" class="btn btn-warning text-dark"><i class="fas fa-edit fa-xs">Edit</i></a>
        <a href="hapusproduk.php?id=<?= $row["produkid"]; ?>" class="btn btn-danger text-dark"><i class="fas fa-edit fa-xs">Hapus</i></a></td>
        </tr>
        <?php endforeach; ?>
    </tbody>
    </table>
</div>

</body>
<script>
    inputfile.onchange = function(){
        if(this.files[0].size > 41000000){
            alert("Batas ukuran size 40MB");
            this.value = "";
        };
    };
</script>
</html>