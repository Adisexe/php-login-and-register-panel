<?php
session_start();

//MYSQL
$dbservername = "localhost";
$dbusername = "root";
$dbpassword = ""; 
$dbname = "db_login";

$conn = new mysqli($dbservername, $dbusername, $dbpassword, $dbname);

if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}
//////////////

if (isset($_POST['username']) && isset($_POST['password']) && isset($_GET["action"])) {
	if (!empty($_POST['username']) && !empty($_POST['password'])) {
		$username = trim($_POST['username']);
		$password = trim($_POST['password']);
		$passwordHash = password_hash($password, PASSWORD_DEFAULT);

		if(!preg_match('/^[a-zA-Z0-9_]+$/', $username)){
			$arr = 'Ta nazwa zawiera niedozwolone znaki';
			$messNotif = urlencode($arr);
			header("Location: index.php?error=$messNotif");
			exit();
		} else {
			$sql = "SELECT * FROM users where username = '$username'";
			$result = mysqli_query($conn, $sql);

			if ($_GET["action"] == 'login'){
				if (mysqli_num_rows($result) > 0) {
					$row = mysqli_fetch_array($result, MYSQLI_ASSOC);

					if (password_verify($password, $row['password'])){			
						$_SESSION['loggin'] = true;
						$_SESSION['userid'] = $row['id'];
						$_SESSION['username'] = $row['username'];

						$arr = 'Zalogowano poprawnie';
						$messNotif = urlencode($arr);

						header("Location: index.php?success=$messNotif");
						mysqli_close($conn);
						exit();
					} else {
						$arr = 'Nazwa użytkownika lub hasło są niepoprawne';
						$messNotif = urlencode($arr);
						header("Location: index.php?error=$messNotif");
						exit();
					}
				} else {
					$arr = 'Nazwa użytkownika lub hasło są niepoprawne';
					$messNotif = urlencode($arr);
					header("Location: index.php?error=$messNotif");
					exit();
				}
			} else if ($_GET['action'] == 'register'){
				if(!empty($_POST['password-confirm'])){
					$passwordConfirm = trim($_POST['password-confirm']);

					if ($password == $passwordConfirm){
						if (mysqli_num_rows($result) > 0) {
							$arr = 'Ta nazwa użytkownika jest zajęta';
							$messNotif = urlencode($arr);
							header("Location: index.php?action=register&error=$messNotif");
							exit();
						} else {
							$sql = "INSERT INTO users (username, password) VALUES ('$username', '$passwordHash')";
							if(mysqli_query($conn, $sql)){
								$arr = 'Rejestracja przebiegła pomyślnie!';
								$messNotif = urlencode($arr);
								header("Location: index.php?success=$messNotif");
								exit();
							} else{
								echo "ERROR: Could not able to execute $sql. " . mysqli_error($conn);
							}
						}
					} else {
						$arr = 'Hasła się nie zgadzają';
						$messNotif = urlencode($arr);
						header("Location: index.php?action=register&error=$messNotif");
						exit();
					}
				} else {
					$arr = 'Uzupełnij pole "Potwierdź hasło"';
					$messNotif = urlencode($arr);
					header("Location: index.php?action=register&error=$messNotif");
					exit();
				}
			}
			
		}
	} else {
		$arr = 'Pola nie mogą pozostać puste';
		$messNotif = urlencode($arr);
		header("Location: index.php?error=$messNotif");
		exit();
	}
}
?>