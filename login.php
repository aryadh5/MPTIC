<?php 
session_start();
if (isset($_SESSION["login"])) {
    header("location:admin.php");
    exit;
}
require 'function.php'; 
$login = query('SELECT * from admin');

if (isset($_POST["submit"])) {

    $username = $_POST["username"];
    $password = $_POST["password"];
    
    $q = "SELECT * FROM admin where username = '$username'";
    $result = mysqli_query($koneksi,$q);
    if (mysqli_num_rows($result) === 1) {
        $row = mysqli_fetch_assoc($result);
        $hp = password_hash($row['password'], PASSWORD_DEFAULT); //sementara, perbaiki setelah registrasi
        if (password_verify($password, $hp)) {
            $_SESSION["login"] = $username;
            header("location: admin.php");
            exit;
        } else {
            echo "<script>
                alert('Username atau password salah');
                </script>";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <script src="https://kit.fontawesome.com/3a675effe7.js" crossorigin="anonymous"></script>
    <title>Document</title>
</head>
<body>
<div class="container text-center" style="padding-top: 10%; padding-bottom:10%;">
        <div class="row justify-content-center">
            <div class="col-lg-6">
                <div class="card">
                    <div class="card-header">
                        LOGIN
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12">
                                <h5 class="card-title"><i class="fas fa-cogs fa-3x"></i></h5>
                                <p class="card-text">Masukkan username dan password ya :)</p>
                                <form action="" method="post">
                                    <div class="form-group py-2">
                                        <input type="text" class="form-control" id="username" name="username" placeholder="Username">
                                    </div>
                                    <div class="form-group py-2">
                                        <input type="password" class="form-control" id="password" name="password" placeholder="Passwword">
                                    </div>
                                    <hr>
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
</body>

</html>
