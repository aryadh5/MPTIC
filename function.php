<?php 
$koneksi = mysqli_connect("localhost", "root", "", "braves");

function query($query)
{
    global $koneksi;
    $result = mysqli_query($koneksi, $query);
    $array = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $array[] = $row;
    }
    return $array;
}

function enum($data){// ambil opsi enum
    global $koneksi;
$result = mysqli_query($koneksi,$data);
$row = mysqli_fetch_assoc($result);
$sproduk = $row['num'];
$enum = array();
preg_match("/^enum\(\'(.*)\'\)$/", $sproduk, $enum);
$vals = explode("','", $enum[1]);
return $vals;}


function upload()
{

    $nama = $_FILES['gambar']['name'];
    $tmpname = $_FILES['gambar']['tmp_name'];
    $size = $_FILES['gambar']['size'];

    $allowed = ['jpg', 'jpeg', 'png']; //Ekstensi yang diperbolehkan

    if ($size > 40000000){
        echo "<script>
            alert('Gambar melebihi batas (40MB)');
            </script>";
        return false;
    }

    $ekstensi = pathinfo($nama, PATHINFO_EXTENSION); //$format menyimpan ekstensi file.
    if (!in_array($ekstensi, $allowed)) {
        echo "<script>
            alert('Bukan gambar');
            </script>";
        return false;
    }


    $namas = mt_rand(10000,99999);
    $namas .= '.';
    $namas .= $ekstensi;

    move_uploaded_file($tmpname, 'img/' . $namas);
    return $namas;
}

function tambahproduk($data)
{
    global $koneksi;

    $nama = htmlspecialchars($data["nama"]);
    $jenis = htmlspecialchars($data["jenis"]);
    $harga = htmlspecialchars($data["harga"]);
    $deskripsi = htmlspecialchars($data["deskripsi"]);

    $gambar = upload();
    if (!$gambar) {
        return false;
    }

    $query = "INSERT INTO produk VALUES('$nama','$jenis','$harga','$gambar','$deskripsi','')";

    mysqli_query($koneksi, $query);
    return mysqli_affected_rows($koneksi);
}

function editproduk($data)
{
    global $koneksi;
    $files = glob("img/*.{jpg,jpeg,png}", GLOB_BRACE); //array nama file di folder
    $cut = array();

    $id = $data["id"];
    $nama = htmlspecialchars($data["nama"]);
    $jenis = htmlspecialchars($data["jenis"]);
    $harga = htmlspecialchars($data["harga"]);
    $deskripsi = htmlspecialchars($data["deskripsi"]);
    $old    = $data["old"];




    if ($_FILES['gambar']['error'] === 4) { //Gambar lama
        $gambar = $old;
    }else{
        $gambar = upload(); //Upload kalo bukan gambar lama
    }

    $row = query("SELECT * FROM produk WHERE produkid=$id");
    foreach ($row as $riw) {
        $file = $riw['gambar'];//ambil nama file di database
    }

    for($k=0; $k<count($files); $k++){
        $cut[$k]=substr($files[$k],4); //Simpan nama file tanpa nama folder
    }  

    if(!empty($cut)){ //Cek jika folder img terdapat file
        for($c=0; $c<count($files); $c++){
            if($file==$cut[$c]){ //Cek jika nama file database terdapat pada folder
                unlink('img/' . $file); //Unlink gambar di folder yang sesuai dengan nama file database
            }
        }
    }

    
    $query = "UPDATE produk SET
              nama = '$nama',
              jenis = '$jenis',
              harga = '$harga',
              gambar = '$gambar',
              deskripsi = '$deskripsi'
              WHERE produkid = $id";


    mysqli_query($koneksi, $query);
    return mysqli_affected_rows($koneksi);
}

function hapusproduk($id)
{
    global $koneksi;
    $row = query("SELECT * FROM produk WHERE produkid=$id");
    foreach ($row as $riw) {
        $file = $riw['gambar'];
    }
    unlink('img/' . $file);
    mysqli_query($koneksi, "DELETE FROM produk WHERE produkid=$id");
    return mysqli_affected_rows($koneksi);
}


function getProductsByType($type = 'all') {
    if ($type === 'all') {
        return query("SELECT * FROM produk");
    } else {
        // Ganti bagian ini dengan prepared statement untuk menghindari SQL injection
        $type = mysqli_real_escape_string($koneksi, $type);
        return query("SELECT * FROM produk WHERE jenis = '$type'");
    }
}


function generateWhatsAppLink($phoneNumber, $message)
{
    $phoneNumber = preg_replace('/[^0-9]/', '', $phoneNumber); // Hapus karakter selain angka
    $message = urlencode($message);
    return "https://api.whatsapp.com/send?phone={$phoneNumber}&text={$message}";
}

// Fungsi untuk memeriksa input form
function validateFormData($data) {
    foreach ($data as $key => $value) {
        // memastikan tidak ada data yang kosong atau tidak valid
        if (empty($value)) {
            return false; // Gagal validasi jika ada data kosong
        }
    }
    return true; // Berhasil divalidasi
}


?>