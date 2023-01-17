<?php 
$conn = mysqli_connect("localhost", "root", "", "fharhan_data");

function query($query) {
	global $conn;
	$result = mysqli_query($conn, $query);
	$rows =[];
    while ( $row = mysqli_fetch_assoc($result) ) {
    	$rows[] = $row;
    }
    return $rows;
}

function tambah($data) {
    global $conn;

    $nama_buah = htmlspecialchars($data["nama_buah"]);
    $asal_buah = htmlspecialchars($data["asal_buah"]);
    $jumlah_buah = htmlspecialchars($data["jumlah_buah"]);
    $harga_buah = htmlspecialchars($data["harga_buah"]);

    // upload gambar
	$gambar = upload();
	if ( !$gambar ) {
		return false;
	}

    $query = "INSERT INTO buahan VALUES('','$nama_buah','$asal_buah','$jumlah_buah','$harga_buah','$gambar')";
    mysqli_query($conn, $query);

    return mysqli_affected_rows($conn);
}

function upload() {
    $namaFile = $_FILES['gambar']['name'];
    $ukuranFile = $_FILES['gambar']['size'];
    $error = $_FILES['gambar']['error'];
    $tmpName = $_FILES['gambar']['tmp_name'];

    // cek apakah gambar sudah diupload atau belum
    if ( $error === 4 ) {
        echo "<script>
                alert('Silahkan Upload Gambar Terlebih Dahulu!');
              </script>";
        return false;
    }

    // cek apakah yang diupload gambar atau bukan
    $ekstensiGambarValid = ['jpg', 'jpeg', 'png'];
    $ekstensiGambar = explode('.', $namaFile);
    $ekstensiGambar = strtolower(end($ekstensiGambar)); 
    if (!in_array($ekstensiGambar, $ekstensiGambarValid)) {
        echo "<script>
                alert('Yang Anda Upload Bukan Gambar!');
              </script>";
        return false;
    }

    // cek ukuran gambar jika terlalu besar
    if ($ukuranFile > 1000000) {
        echo "<script>
                alert('Ukuran Gambar Terlalu Besar!');
              </script>";
        return false;
    }

    // lolos pengecekan, gambar siap diupload
    // generate nama gambar baru
    $namaFileBaru = uniqid();
    $namaFileBaru .= '.';
    $namaFileBaru .= $ekstensiGambar;

    move_uploaded_file($tmpName, 'img/' . $namaFileBaru);

    return $namaFileBaru;
}

function ubah($data) {
    global $conn;

    $id = $data["id"];
    $nama_buah = htmlspecialchars($data["nama_buah"]);
    $asal_buah = htmlspecialchars($data["asal_buah"]);
    $jumlah_buah = htmlspecialchars($data["jumlah_buah"]);
    $harga_buah = htmlspecialchars($data["harga_buah"]);
    $gambarLama = htmlspecialchars($data["gambarLama"]);

    // cek apakah user mengubah gambar baru atau tidak
    if ($_FILES['gambar']['error'] === 4 ) {
        $gambar = $gambarLama;
    } else {
        $gambar = upload();
    }

    $query = "UPDATE buahan SET
            nama_buah = '$nama_buah', 
            asal_buah = '$asal_buah', 
            jumlah_buah = '$jumlah_buah', 
            harga_buah = '$harga_buah', 
            gambar = '$gambar' 
        WHERE id = $id";
    mysqli_query($conn, $query);

    return mysqli_affected_rows($conn);
}

function hapus($id) {
	global $conn;
    mysqli_query($conn, "DELETE FROM buahan WHERE id = $id");
	
	return mysqli_affected_rows($conn);
}

function cari($keyword) {
    $query = "SELECT * FROM buahan WHERE
        nama_buah LIKE '%$keyword%' OR
        asal_buah LIKE '%$keyword%' OR
        jumlah_buah LIKE '%$keyword%' OR
        harga_buah LIKE '%$keyword%'
    ";

    return query($query);
}

function registrasi($data){
    global $conn;
    
    $username = strtolower(stripslashes($data["username"]));
    $password = mysqli_real_escape_string($conn, $data["password"]);
    $password2 = mysqli_real_escape_string($conn, $data["password2"]);

    // cek apakah username sudah ada atau belum
    $result = mysqli_query($conn, "SELECT * FROM user_buah WHERE username = '$username'");

    if (mysqli_fetch_assoc($result)) {
        echo "<script>
                alert('Username sudah terdaftar!')
             </script>";
        return false;
    }

    // cek konfirmasi password
    if($password !== $password2){ 
        echo "<script>
            alert('Konfirmasi password tidak sesuai!');
        </script>";
        return false;
    }

    // enkripsi password
    $password = password_hash($password, PASSWORD_DEFAULT);

    // tambahkan username baru ke database
    mysqli_query($conn, "INSERT INTO user_buah VALUES('', '$username', '$password')");

    return mysqli_affected_rows($conn);
}

?>