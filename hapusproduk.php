<?php
require 'function.php';

if (isset($_GET["id"]) && is_numeric($_GET["id"])) {
    $id = $_GET["id"];
    if (hapusproduk($id) > 0) {
        echo "<script>
            alert('Produk berhasil di hapus');
            document.location.href='admin.php';
            </script>";
    } else {
        echo "<script>
            alert('Produk gagal di hapus');
            document.location.href='admin.php';
            </script>";
    }
} else {
    echo "<script>
        alert('ID produk tidak valid');
        document.location.href='admin.php';
        </script>";
}
?>
