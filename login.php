<?php
session_start();
include 'dbconnect.php';
$alert = '';

if (isset($_SESSION['role'])) {
	$role = $_SESSION['role'];

	if ($role == 'Admin') {
		header("Location: admin");
	} elseif ($role == 'User') {
		header("Location: user");
	} elseif ($role == 'Anggota') {
		header("Location: anggota");
	}
}


if (isset($_POST['btn-login'])) {
	$email = mysqli_real_escape_string($conn, $_POST['email']);
	$password = mysqli_real_escape_string($conn, $_POST['password']);

	// menyeleksi data user dengan username dan password yang sesuai
	$cariadmin = mysqli_query($conn, "select * from admin where adminemail='$email' and adminpassword='$password';");
	$cariuser = mysqli_query($conn, "select * from user where useremail='$email' and userpassword='$password';");
	$carianggota = mysqli_query($conn, "select * from anggota where anggotaemail='$email' and anggotapassword='$password';");


	// menghitung jumlah data yang ditemukan
	$cekadmin = mysqli_num_rows($cariadmin);
	$cekuser = mysqli_num_rows($cariuser);
	$cekanggota = mysqli_num_rows($carianggota);

	// cek apakah username dan password di temukan pada database
	if ($cekadmin > 0) {
		// jika admin
		$data = mysqli_fetch_assoc($cariadmin);
		$_SESSION['email'] = $data['adminemail'];
		$_SESSION['role'] = "Admin";
		header("location:admin");
	} else if ($cekanggota > 0) { // periksa anggota sebelum user
		// jika anggota
		$data = mysqli_fetch_assoc($carianggota);
		$_SESSION['email'] = $data['anggotaemail'];
		$_SESSION['anggotaid'] = $data['anggotaid'];
		$_SESSION['role'] = "Anggota";
		header("location:anggota");
	} else if ($cekuser > 0) {
		// jika user biasa
		$data = mysqli_fetch_assoc($cariuser);
		$_SESSION['email'] = $data['useremail'];
		$_SESSION['userid'] = $data['userid'];
		$_SESSION['role'] = "User";
		header("location:user");
	} else {
		//jika user tidak ditemukan
		echo "<div class='alert alert-warning'>Username atau Password salah</div>
    <meta http-equiv='refresh' content='2'>";
	}
}


?>


<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Masuk</title>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css">
	<link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>
	<!-- Global site tag (gtag.js) - Google Analytics -->
	<script async src="https://www.googletagmanager.com/gtag/js?id=UA-144808195-1"></script>
	<script>
		window.dataLayer = window.dataLayer || [];

		function gtag() {
			dataLayer.push(arguments);
		}
		gtag('js', new Date());

		gtag('config', 'UA-144808195-1');
	</script>
	<script src="jquery.min.js"></script>
	<style>
		body {
			background-color: #2c3e50;
			background-size: cover;
			background-position: center;
			margin: 100;

		}

		@media screen and (max-width: 600px) {
			h4 {
				font-size: 0%;
			}
		}

		.container {
			background-color: #2c3e50;
			width: 70%;
			border: 3px white;
			border-style: solid;
			border-radius: 30px;
			padding-left: 10%;
			padding-right: 10%;
			padding-top: 3%;
			padding-bottom: 2%;
		}

		.btn {
			width: 20%;
		}
	</style>
	<link rel="icon" type="image/png" href="favicon.png">
</head>

<body>

	<div align="center">



		<p style="margin-top:5%; 
          font-size:50px; 
          color: #00BFFF; 
          font-family: 'Arial', sans-serif; 
          font-weight: bold;
          text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.3);
          background: linear-gradient(to right, #00BFFF, #1E90FF);
          -webkit-background-clip: text;
          -webkit-text-fill-color: transparent;">
			Log In
		</p>



		<br \><br \>
		<div class="container">
			<span style="float: left">
				<a class="w3-btn w3-blue w3-large" href="index.php">Kembali</a>
			</span>
			<div style="color:#2c3e50">
				<label>ssdsdsds</label><br \>
				<label>asasadasdadsa</label><br \>
				<label>dasdasdasdsa</label>
			</div>
			<form method="post">
				<div class="form-group">
					<input type="email" class="form-control" placeholder="Email" name="email" autofocus required>
				</div>
				<div class="form-group">
					<input type="password" class="form-control" placeholder="Password" name="password" required>
				</div>
				<button type="submit" class="btn btn-primary" style="float: left" name="btn-login">Masuk</button>
				<a class="btn btn-info text-light" style="float: right" href="register.php">Daftar</a>
			</form>

			<br \>
		</div>
	</div>




</body>

</html>