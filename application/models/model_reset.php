<?php 
session_start();
class Model_Reset extends Model {
    private static $update_db = "UPDATE users SET `reset_link`=:reset_link WHERE `e-mail`=:email";
    private static $update_password = "UPDATE users SET password=:password WHERE reset_link=:reset_link";

	function reset_password($email) {
        include "config/database.php";
		if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
			$_SESSION['message'] = "INVALID E-MAIL";
			header('Location: ../reset');
			exit();
        }
        else {
            try {
                $dbh = new PDO($dsn, $db_user, $db_password, $options);
                $dbh->exec('USE camagru_db');
                $reset_link = time(hash('whirlpool', $email));
                $arr = array('email' => $email, 'reset_link' => $reset_link);
                if ($this->add_info_to_db($dbh, Model_Reset::$update_db, $arr) === Model::SUCCESS) {
                    $this->reset_email($email, $reset_link);
                    return Model::SUCCESS;
                }
            return Model::ERROR;
            }
            catch (PDOException $err) {
                $err->getMessage();
                return Model::ERROR;
            }
        }
    }

    private function add_info_to_db($dbh, $sql, $arr) {
		try {
			$stmt = $dbh->prepare($sql);
			$stmt->execute($arr);
			return Model::SUCCESS;
		}
		catch (PDOException $err) {
            $err->getMessage();
			return Model::ERROR;	
		}
	}
    
	function reset_email($email, $reset_link) {
		include "config/database.php";
		$subject 	= "Reset you Camagru password";
		$body 		= "Hi!" . "\r\n\n" . "Don't worry, we all forget sometimes! You've recently asked to reset the password for this Camagru account:" . "\r\n" . $email . "\r\n\n" . "To update your password, follow this link: http://" . $host . "/reset/confirm/reset_link?" . $reset_link . "\r\n\n" . "Cheers," . "\r\n" . "Camagru";
		$header 	= "From: info@camagru.com";
					"CC: info@camagru.com";
		if (mail($email, $subject, $body, $header)) {
			$_SESSION['message'] = "WE SEND A VERIFICATION LINK TO YOUR E-MAIL, PLEASE CHECK IT";
			return Model::SUCCESS;
		}
		return Model::ERROR;
    }
    
    function set_reset_link() {
		include "config/database.php";
		$url = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
        $reset_link = parse_url($url, PHP_URL_QUERY);
		try {
			$dbh = new PDO($dsn, $db_user, $db_password, $options);
			$dbh->exec('USE camagru_db');
			$query = "SELECT * FROM users WHERE reset_link = ?";
            $arr = array($reset_link);
			$stmt = $dbh->prepare($query);
			$stmt->execute($arr);
			$data = $stmt->fetch();
			if ($data) {
				$query = "UPDATE users SET password = 1 WHERE reset_link=?";
				$stmt = $dbh->prepare($query);
				$stmt->execute(array($data['reset_link']));
				$hello = $stmt->fetch();
                header('location: ../newpassword');
                $_SESSION['reset_link'] = $reset_link;
                return Model::SUCCESS;
			}
			return Model::ERROR;		
		}
		catch (PDOException $err) {
			$err->getMessage();
			return Model::ERROR;
		}
	}

    function update_password() {
        // include "config/database.php"; 
		// if ($_POST['password_new'] !== $_POST['password_confirm']) {
		// 	$_SESSION['message'] = "PASSWORDS DOESN'T MATCH";
		// 	header('Location: ../newpassword');
		// 	exit();
		// }
		// else if ($_POST['password_new'] === strtolower($_POST['password_new']) or strlen($_POST['password_new']) < 4) {
		// 	$_SESSION['message'] = "YOUR PASSWORD MUST CONTAIN AT LEAST 5 CHARACTERS AND 1 UPPERCASE LETTER";
		// 	header('Location: ../signup');
		// 	exit();
		// }
		// else {
		// 	try {
		// 		$dbh = new PDO($dsn, $db_user, $db_password, $options);
		// 		$dbh->exec('USE camagru_db');
		// 		$arr = array('reset_link' => $reset_link, 'password' => hash("whirlpool", $password));
		// 		if ($this->add_info_to_db($dbh, Model_Reset::$update_password, $arr) === Model::SUCCESS) {
        //             header('Location: ../auth');
		// 			return Model::SUCCESS;
		// 		}
		// 		return Model::ERROR;
		// 	}
		// 	catch(PDOxception $err) {
		// 		$err->getMessage();
		// 		return Model::ERROR;
		// 	}
        }
    }
    