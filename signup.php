<?php

	function check_input($data)
	{	
		$data = trim($data);
		$data = stripslashes($data);
		$data = htmlspecialchars($data);
		return $data;
	}

	function validateEmail($email)
	{
		$regex = '/^([\w-]+(?:\.[\w-]+)*)@((?:[\w-]+\.)*\w[\w-]{0,66})\.([a-z]{2,6}(?:\.[a-z]{2})?)$/i';
	
		if($email == '') { 
			return false;
		} else {
			$string = preg_replace($regex, '', $email);
		}
	
		return empty($string) ? true : false;
	}


	$email = check_input($_POST['email']);

	if (!validateEmail($email)) {
		//display error message
		$response_status = 0;	
		echo '<p>Please enter a valid e-mail address</p>';
	}
	else {
		mysql_connect("localhost", "root", "Fertile5") or die(mysql_error());
		mysql_select_db("ssc") or die(mysql_error());

		$response_status = 1;

		$strSQL = "SELECT * FROM emails ORDER BY id DESC";
		$rs = mysql_query($strSQL);
		while ($row = mysql_fetch_array($rs)) {
			if ($email == $row['email']) {
				$response_status = 0;	
				echo '<p>That email address is already registered</p>';
				break;
			}
		}

		if ($response_status == 1) {
			$strSQL = "INSERT INTO emails(";
			$strSQL = $strSQL . "email) ";
			$strSQL = $strSQL . "VALUES(";
			$strSQL = $strSQL . "'" . $email . "')";

			mysql_query($strSQL) or die(mysql_error());

			echo '<p>Thank you. You have successfully registered your email to receive news from us!</p>';
		}

		mysql_close();
	}

?>