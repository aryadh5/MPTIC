<?php
require 'function.php';

$jenis = $_GET['jenis'] ?? 'all';
$produk = getProductsByType($jenis);

$jenis_produk = array();
foreach ($produk as $row) {
    $nomor_telepon = '6281234567890'; // Ganti dengan nomor telepon yang sebenarnya
    $pesan = 'Halo, saya tertarik dengan produk' . $row['nama'] . '. Mohon informasi lebih lanjut.';
    $pesan_url = generateWhatsAppLink($nomor_telepon, $pesan);
    $jenis_produk[] = $row['jenis'];
}
$jenis_produk = array_unique($jenis_produk);
sort($jenis_produk);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Head content -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
</head>
<body>
    <div class="container text-center">
        <div class="row mt-3">
            <div class="col">
                <form method="get">
                    <div class="input-group">
                        <label class="input-group-text" for="jenis">Filter berdasarkan jenis:</label>
                        <select class="form-select" name="jenis" id="jenis" onchange="this.form.submit()">
                            <option value="all">All</option>
                            <?php foreach ($jenis_produk as $jenis): ?>
                                <option value="<?= $jenis; ?>" <?= isset($_GET['jenis']) && $_GET['jenis'] == $jenis ? 'selected' : ''; ?>><?= $jenis; ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </form>
            </div>
        </div>

        <div class="row mt-3">
            <?php foreach($produk as $row):?>
                <div class="col">
                    <div class="card" style="width: 18rem;">
                        <img src="img/<?= $row['gambar'];?>" class="card-img-top" alt="...">
                        <div class="card-body">
                            <h4 class="card-title"><?= $row['nama'];?></h4>
                            <h5 class="card-title"><?= $row['jenis'];?></h5>
                            <p class="card-text"><?= $row['harga'];?></p>
                            <p class="card-text"><?= $row['deskripsi'];?></p>
                            <a href="<?= $pesan_url; ?>" class="btn btn-success">Pesan di WhatsApp</a>
                        </div>
                    </div>
                </div>
            <?php endforeach?>
        </div>
    </div>

    <!-- Bootstrap scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
</body>
</html>
