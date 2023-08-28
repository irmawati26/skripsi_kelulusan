<?php
include "../database.php";
?>
<!doctype html>
<html lang="en">

<head>
	<title>Login 08</title>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<link href="https://fonts.googleapis.com/css?family=Lato:300,400,700&display=swap" rel="stylesheet">
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
	<link rel="stylesheet" href="css/style.css">
</head>

<body>
	<?php
	if (isset($_REQUEST['submit'])) {
		$username = $_REQUEST['username'];
		$username = preg_replace('/[^a-zA-Z0-9]/', '', $username);
		$password = MD5($_REQUEST['password']);

		$hasil = mysqli_query($db_conn, "SELECT * FROM un_user WHERE username='$username' AND password='$password'");
		if (mysqli_num_rows($hasil) > 0) {
			session_start();
			$data = mysqli_fetch_array($hasil);
			$_SESSION['logged'] = $data['UID'];
			$_SESSION['username'] = $data['username'];
			/* jika fungsi:
																																																  header('Location: ./');
																																															 tidak bisa digunakan, HAPUS atau berikan tanda komentar
																																															 kemudian aktifkan (hapus tanda //) pada skrip:
																																																  echo '<script>window.location("./");</script>';
																																														  */
			header('Location: ./');
			//echo '<script>window.location("./");</script>';
		} else {
			echo '<script>alert("Username dan Password tidak sesuai!");</script>';
		}
	}

	?>
	<section class="ftco-section">
		<div class="container">
			<div class="row justify-content-center">
				<div class="col-md-6 col-lg-5">
					<div class="login-wrap p-4 p-md-5">
						<div class="container d-flex justify-content-center align-items-center">
							<!-- Use the "d-flex justify-content-center align-items-center" classes to center the image -->
							<img src="../logo.png" alt="Logo" style="height: 150px;">
						</div>
						<h3 class="text-center mb-4">Selamat Datang</h3>
						<form method="post" class="login-form">
							<div class="form-group">
								<input type="text" name="username" id="inputUsername" class="form-control rounded-left"
									placeholder="Username" required>
							</div>
							<div class="form-group d-flex">
								<input type="password" name="password" id="inputPassword"
									class="form-control rounded-left" placeholder="Password" required>
							</div>
							<div class="form-group d-md-flex">
								<div class="w-50">
									<label class="checkbox-wrap checkbox-primary">Remember Me
										<input type="checkbox" checked>
										<span class="checkmark"></span>
									</label>
								</div>
								<div class="w-50 text-md-right">
									<a href="#">Forgot Password</a>
								</div>
							</div>
							<div class="form-group">
								<button type="submit" name="submit" class="btn btn-primary rounded submit p-3 px-5">Get
									Started</button>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
	</section>

	<script src="js/jquery.min.js"></script>
	<script src="js/popper.js"></script>
	<script src="js/bootstrap.min.js"></script>
	<script src="js/main.js"></script>

</body>

</html>