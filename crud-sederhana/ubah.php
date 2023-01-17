<?php 

session_start();
if(!isset($_SESSION["login"])){
    header("Location: login.php");
    exit;
}

require("functions.php");

// ambil data di url
$id = $_GET["id"];

// query data buah berdasarkan id
$buah = query("SELECT * FROM buahan WHERE id = $id")[0];

// cek apakah tombol submit sudah ditekan
if ( isset($_POST["submit"]) ) {
    
    ubah($_POST);
    // cek apakah data berhasil diubah atau tidak
    if ( mysqli_affected_rows($conn) > 0 ) {
    	echo "
            <script>
                alert('data berhasil diubah!');
                document.location.href = 'index.php';
            </script>
    	";
    } else {
    	echo "
			<script>
                alert('data gagal diubah!');
                document.location.href = 'index.php';
            </script>
    	";
    	echo "<br>";
    	echo mysqli_error($conn);
    }
}

?>

<!DOCTYPE html>
<html>
<head>
	<title>Ubah Data Buah</title>
</head>
<body>
    <h1>Ubah data Buah</h1>
    <form action="" method="post" enctype="multipart/form-data">
        <table>
            <input type="hidden" name="id" value="<?= $buah["id"]; ?>">
            <input type="hidden" name="gambarLama" value="<?= $buah["gambar"]; ?>">
            <tr>
                <td>
                    <label for="nama_buah">Nama Buah </label>
                </td>
                <td>:</td>
                <td>
                    <input type="text" name="nama_buah" id="nama_buah" require="" value="<?= $buah["nama_buah"] ?>">
                </td>
            </tr>
            <tr>
                <td>
                    <label for="asal_buah">Asal Buah </label>
                </td>
                <td>:</td>
                <td>
                    <input type="text" name="asal_buah" id="asal_buah" value="<?= $buah["asal_buah"]; ?>">
                </td>
            </tr>
            <tr>
                <td>
                    <label for="jumlah_buah">Jumlah Buah </label>
                </td>
                <td>:</td>
                <td>
                    <input type="text" name="jumlah_buah" id="jumlah_buah" value="<?= $buah["jumlah_buah"]; ?>">
                </td>
            </tr>
            <tr>
                <td>
                    <label for="harga_buah">Harga Buah </label>
                </td>
                <td>:</td>
                <td>
                    <input type="text" name="harga_buah" id="harga_buah" value="<?= $buah["harga_buah"]; ?>">
                </td>
            </tr>
            <tr>
                <td>
                    <label for="gambar">Gambar </label>
                </td>
                <td>:</td>
                <td>
                    <input type="file" name="gambar" id="gambar">
                </td>
            </tr>
            <tr>
                <td></td>
                <td></td>
                <td>
                    <img src="img/<?= $buah["gambar"]; ?>" width="180px" height="180px" style="border: 1px solid black; border-radius: 5px;">
                </td>
            </tr>
            <tr>
                <td>
                    <button type="submit" name="submit">Ubah Data</button>
                </td>
                <td></td>
                <td>
                    <a href="index.php">kembali</a>
                </td>
            </tr>
        </table>
    </form>
</body>
</html>