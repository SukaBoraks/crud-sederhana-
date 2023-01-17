<?php 

session_start();
if(!isset($_SESSION["login"])){
	header("Location: login.php");
	exit;
}

// Menghubungkan ke halaman functions.php
require 'functions.php';
$buahan = query("SELECT * FROM buahan");

// Tombol cari ditekan
if(isset($_POST["cari"])) {
	$buahan = cari($_POST["keyword"]);
}
?>

<!DOCTYPE html>
<html>
<head>
	<title>Halaman</title>
</head>
<body>
	<h1>Data Buah Buahan</h1>
	<p>
		<a href="tambah.php">Tambah Data Buah</a>
	</p>
	<form action="" method="post">
		<input type="text" name="keyword" size="40px" autofocus placeholder="Masukkan Keyword Pencarian..." autocomplete="off">
		<button type="submit" name="cari">Cari!!!</button>
	</form>
	<br>
	<table border="1" cellpadding="10" cellspacing="0">
		<tr>
			<th>No.</th>
			<th>Aksi</th>
			<th>Gambar</th>
			<th>Nama Buah</th>
			<th>Asal Buah</th>
			<th>Jumlah Buah</th>
			<th>Harga Buah</th>
		</tr>
		<?php $i = 1; ?>
		<?php foreach ($buahan as $row): ?>
		<tr>
			<td><?= $i; ?></td>
			<td>
				<a href="ubah.php?id=<?= $row["id"]; ?>">ubah</a> | 
				<a href="hapus.php?id=<?= $row["id"]; ?>" onclick="return confirm('yakin?');">hapus</a>
			</td>
			<td><img src="img/<?= $row["gambar"]; ?>" width="50" height="50" style="border: 1px solid black; border-radius: 5px;"></td>
			<td><?= $row["nama_buah"]; ?></td>
			<td><?= $row["asal_buah"]; ?></td>
			<td><?= $row["jumlah_buah"]; ?></td>
			<td><?= $row["harga_buah"]; ?></td>
		</tr>
		<?php $i++ ?>
		<?php endforeach ?>
	</table>
	<a href="logout.php">Logout</a>
</body>
</html>