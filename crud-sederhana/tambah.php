<?php 

session_start();
if(!isset($_SESSION["login"])){
    header("Location: login.php");
    exit;
}

// hubungkan ke dbms
require "functions.php";

// cek apakah tombol submit sudah ditekan atau belum
if( isset($_POST["submit"]) ) {

    // cek apakah data berhasil ditambahkan atau tidak
   if( tambah($_POST) > 0 ) {
        echo "<script>
                alert('Data berhasil ditambahkan!');
                document.location.href='index.php';
            </script>";
   } else {
        echo "<script>
            alert('Data gagal ditambahkan!');
            document.location.href='index.php';
        </script>";
   }

}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Data Buah</title>
</head>
<body>
    <h1>Tambah Data Buah</h1>
    <form action="" method="post" enctype="multipart/form-data">
        <table>
            <tr>
                <td>
                    <label for="nama_buah">Nama Buah </label>
                </td>
                <td>:</td>
                <td>
                    <input type="text" name="nama_buah" id="nama_buah">
                </td>
            </tr>
            <tr>
                <td>
                    <label for="asal_buah">Asal Buah </label>
                </td>
                <td>:</td>
                <td>
                    <input type="text" name="asal_buah" id="asal_buah">
                </td>
            </tr>
            <tr>
                <td>
                    <label for="jumlah_buah">Jumlah Buah </label>
                </td>
                <td>:</td>
                <td>
                    <input type="text" name="jumlah_buah" id="jumlah_buah">
                </td>
            </tr>
            <tr>
                <td>
                    <label for="harga_buah">Harga Buah </label>
                </td>
                <td>:</td>
                <td>
                    <input type="text" name="harga_buah" id="harga_buah">
                </td>
            </tr>
            <tr>
                <td>
                    <label for="gambar">Gambar </label>
                </td>
                <td>:</td>
                <td>
                    <input type="file" name="gambar" id="gambars">
                </td>
            </tr>
            <tr>
                <td>
                    <button type="submit" name="submit">Tambah Data</button>
                </td>
            </tr>
        </table>
    </form>
    <a href="index.php">Kembali Ke Halaman Utama</a>
</body>
</html>

