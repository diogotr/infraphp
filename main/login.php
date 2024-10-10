<?php
// Initialize the session
session_start();

// Check if the user is already logged in, if yes then redirect him to welcome page
if (isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true) {
	header("location: ../main/index.php");
	exit;
}

// Include db file
require_once '../include/db.php';

// Define variables and initialize with empty values
$username = $password = "";
$username_err = $password_err = $login_err = "";
$attempt_count = 0;

// Processing form data when form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {

	$username = htmlspecialchars(trim($_POST["username"]));
	$password = htmlspecialchars(trim($_POST["password"]));

	// Check if username is empty
	if ($username == "") {
		$username_err = "Preencha o e-mail.";
	}

	// Check if password is empty
	if ($password == "") {
		$password_err = "Preencha a senha.";
	}


	// Validate credentials
	if (empty($username_err) && empty($password_err)) {
		// Select statement
		$stmt = $db->query('SELECT id, username, password, usertype, status, attempt_count FROM users WHERE username = ?', $username)->fetchArray();
		if (count($stmt) > 0) {
			$id = $stmt['id'];
			$username = $stmt['username'];
			$hashed_password = $stmt['password'];
			$usertype = $stmt['usertype'];
			$status = $stmt['status'];
			$attempt_count = isset($stmt['attempt_count']) ? intval($stmt['attempt_count']) : 0;

			if (password_verify($password, $hashed_password)) {

				if ($status == 'B') {

					$login_err = "Acesso bloqueado. Excedeu o número de tentativas.";

				} else if ($status == 'I' && $usertype != 'A') {
					$login_err = "Usuário está inativo. Aguarde liberação.";
				} else {

					// Password is correct, so start a new session
					session_start();

					// Store data in session variables
					$_SESSION["loggedin"] = true;
					$_SESSION["id"] = $id;
					$_SESSION["username"] = $username;
					$_SESSION["usertype"] = $usertype;
					$_SESSION['LAST_ACTIVITY'] = time(); // timestamp da session para fazer o timeout  

					// Zera o numero de tentativas incorretas
					$db->query("UPDATE users SET attempt_count = 0 WHERE id=$id");
					// Redirect user to welcome page
					header("location: index.php");

				}

			} else {

				// increase the attempt count, block after 3 tries
				$attempt_count += 1;
				// Password is not valid
				if ($attempt_count >= 4) {
					$login_err = "Acesso bloqueado. Excedeu o número de tentativas.";
					$db->query("UPDATE users SET status = 'B' WHERE id=$id");
				} else {
					$login_err = "E-mail ou senha inválidos. Você tem mais " . (4 - $attempt_count) . ' tentativas.';
					$db->query("UPDATE users SET attempt_count = $attempt_count WHERE id=$id");
				}

				$ip_address = $_SERVER["REMOTE_ADDR"];
				$time = time();
				// insert into tries
				$db->query("INSERT INTO login_history (userid,ip_address,time) VALUES ($id,'$ip_address','$time')");
			}
		} else {
			// Username doesn't exist, display a generic error message
			$login_err = "E-mail ou senha inválidos.";
		}
	}
	$db->close();
}



?>


<!doctype html>
<html lang="en">

<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Infrasoft Systems</title>
	<link rel="stylesheet" href="css.css">
	<link rel="stylesheet" href="../static/css/bootstrap.min.css">
	<!-- Favicon -->
	<link rel="apple-touch-icon" sizes="180x180" href="../static/img/apple-touch-icon.png">
	<link rel="icon" type="image/png" sizes="32x32" href="../static/img/favicon-32x32.png">
	<link rel="icon" type="image/png" sizes="16x16" href="../static/img/favicon-16x16.png">

</head>

<body class="bg-dark text-white">


	<div class="container h-100">
		<div class="row h-100">
			<div class="col-sm-10 col-md-8 col-lg-6 mx-auto d-table h-100">
				<div class="d-table-cell align-middle">

					<div class="text-center mt-4">
						<h1 class="h2">Infrasoft Systems</h1>
						<p class="lead">
							Welcome to Infrasoft Systems, here you have the best and fast development.
						</p>
					</div>

					<div class="card text-dark">
						<div class="card-body">
							<div class="m-sm-4">
								<form action="" method="post">
									<div class="form-group">
										<label>Email</label>
										<input class="form-control form-control-lg" type="email" name="username"
											placeholder="Enter your email" required>
									</div>
									<div class="form-group">
										<label>Password</label>
										<input class="form-control form-control-lg" type="password" name="password"
											placeholder="Enter password" autocomplete="off" required>
									</div>
									<div class="text-center mt-3">
										<?php
										if (!empty($login_err)) {
											echo '<div class="alert alert-danger">' . $login_err . '</div>';
										}
										?>
										<button type="submit" class="btn btn-lg btn-primary">Sign in</button>
									</div>
								</form>
							</div>
							<div class="d-flex justify-content-between">
								<div>
									If you don't have an account <a href="signup.php">Sign up</a>
								</div>
								<div>
									<a href="#">Reset password</a>
								</div>
							</div>
						</div>
					</div>
					<p class="mt-5 mb-3 text-center">2024 Copyright &copy; Diogo Rossato</p>
				</div>
			</div>
		</div>
	</div>
	<script src="../static/js/jquery-3.7.1.min.js"></script>
	<script src="../static/js/bootstrap.bundle.min.js"></script>

</body>

</html>