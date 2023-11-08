<?php
session_start();
if (!isset($_SESSION["login"])) {
    header("location:login.php");
    exit;
}
require 'function.php';

$id = $_GET["id"];
$produk = query("SELECT * FROM produk WHERE produkid = ?");
$produks = "SELECT COLUMN_TYPE AS num FROM INFORMATION_SCHEMA.COLUMNS WHERE COLUMN_NAME = 'jenis'";
$enum = enum($produks);
$i = 0;

if (isset($_POST["submit"])) {
    // Validasi CSRF Token di sini
    if ($_POST['csrf_token'] === $_SESSION['csrf_token']) {
        
        if (!validateFormData($_POST)) {
            echo "<script>
                alert('Harap isi semua field dengan benar.');
                </script>";
        }
        if (editproduk($_POST) > 0) {
            echo "<script>
                alert('Data berhasil diubah');
                document.location.href='admin.php';
                </script>";
        } else {
            echo "<script>
                alert('Data gagal diubah');
                document.location.href='editproduk.php?id=$id';
                </script>";
        }
    } else {
        echo "<script>
            alert('CSRF token tidak valid.');
            document.location.href='editproduk.php?id=$id';
            </script>";
    }
}

$csrf_token = bin2hex(random_bytes(32));
$_SESSION['csrf_token'] = $csrf_token;
?>
<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <script src="https://kit.fontawesome.com/3a675effe7.js" crossorigin="anonymous"></script>
</head>

<body>
    <div class="container text-center">
        <div class="row justify-content-center">
            <div class="col-lg-6">
                <div class="card">
                    <div class="card-header">
                        Edit produk
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12">
                                <p class="card-text">Masukkan sesuai form ya</p>
                                <hr>
                                <form action="" method="post" enctype="multipart/form-data">
                                    <?php foreach ($produk as $row) :
                                        $jenis = $row["jenis"]; ?>
                                        <input type="hidden" name="old" value="<?= $row["gambar"]; ?>">
                                        <input type="hidden" name="id" value="<?= $row["produkid"]; ?>">
                                        <img src="img/<?= $row['gambar'];?>" class="card-img-top img-thumbnail" alt="...">
                                        <div class="form-group py-1">
                                        <label for="nama" style="float:left;">Nama</label>
                                        <input class="form-control" type="text" name="nama" value="<?= $row["nama"]; ?>" required>
                                         </div>
                                         <div class="form-group py-1">
                                         <label for="harga" style="float:left;">Harga</label>
                                        <input class="form-control" type="text" name="harga" value="<?= $row["harga"]; ?>" required>
                                         </div>
                                         <div class="form-group py-1">
                                         <label for="deskripsi" style="float:left;">Deskripsi</label>
                                        <textarea class="form-control" type="textarea" name="deskripsi" value="<?= $row["deskripsi"]; ?>" required><?= $row["deskripsi"]; ?></textarea>
                                         </div>

                                         <div class="form-group py-1">
                                         <label for="deskripsi" style="float:left;">Gambar</label>
                                         <input class="form-control" type="file" id="gambar" name="gambar" placeholder="gambar">
                                         </div>
                                         
                                        
                                         <div class="form-group py-2">
                                        <label for="jenis" style="float:left;">Jenis</label>
                                    <?php endforeach; ?>
                                    <select class="form-select" aria-label="Default select example" name="jenis" id="jenis">
                                        <?php for($i; $i<count($enum); $i++){
                                        if($enum[$i] == $jenis){?>
                                        <option value="<?= $enum[$i];?>"Selected><?= $enum[$i];?></option>
                                        <?php }else{ ?>
                                        <option value="<?= $enum[$i];?>"><?= $enum[$i];?></option>
                                        <?php }}?>    
                                        </select>
                                        </div>
                                        <button class="btn btn-dark" type="submit" name="submit">submit</button>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer text-muted">
                        Braves
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
    <script>
    inputfile.onchange = function(){
        if(this.files[0].size > 41000000){
            alert("Batas ukuran size 40MB");
            this.value = "";
        };
    };
    </script>
</body>

</html>