<?php 

session_start();

require 'functions.php';

// cek cookie
if(isset($_COOKIE['id']) && isset($_COOKIE['key'])){
    $id = $_COOKIE['id'];
    $key = $_COOKIE['key'];

    // ambil username berdasarkan id
    mysqli_query($conn, "SELECT username FROM user_buahan WHERE id = $id");
    $row = mysqli_fetch_assoc($result);

    // cek cookie dan username
    if($key === hash('sha256', $row['username'])){
        $_SESSION = true;
    }
}

// cek jika sudah login maka kembalikan ke halaman index
if(isset($_SESSION["login"])){
    header("Location: index.php");
    exit;
}

if(isset($_POST["login"])){
    
    $username = $_POST["username"];
    $password = $_POST["password"];

    $result = mysqli_query($conn, "SELECT * FROM user_buah WHERE username = '$username'");
    
    // cek username
    if(mysqli_num_rows($result) === 1){
        // cek password
        $row = mysqli_fetch_assoc($result);
        if(password_verify($password, $row["password"])){
            // cek session
            $_SESSION["login"] = true;
            // cek remember me (cookie)
            if(isset($_POST['remember'])){
                // buat cookie
                setcookie('id', $row['id'], time()+60);
                setcookie('key', hash('sha256', $row['username'], time()+60));
            }
            header("Location: index.php");
            exit;
        }
    }

    $error = true;
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Halaman Login</title>
</head>
<body>
    <h1>Halaman Login</h1>
    <?php if(isset($error)) : ?>
        <p style="color: red; font-style: italic;">Username atau Password salah!</p>
    <?php endif; ?>
    <form action="" method="post">
        <table>
            <tr>
                <td>
                    <label for="username">Username</label>
                </td>
                <td>:</td>
                <td>
                    <input type="text" name="username" id="username">
                </td>
            </tr>
            <tr>
                <td>
                    <label for="password">Password</label>
                </td>
                <td>:</td>
                <td>
                    <input type="password" name="password" id="password">
                </td>
            </tr>
            <tr>
                <td>
                    <label for="remember">Remember Me</label>
                </td>
                <td></td>
                <td>
                    <input type="checkbox" name="remember" id="remember">
                </td>
            </tr>
            <tr>
                <td>
                    <button type="submit" name="login">Login</button>
                </td>
            </tr>
        </table>
        <!-- <p>Belum punya akun? <a href="registrasi.php">Register</a></p> -->
    </form>
</body>
</html>