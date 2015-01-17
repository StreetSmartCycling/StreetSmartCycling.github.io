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
		$response = array();
		$response['status'] = 0;	
		$response['html'] = '<p>Please enter a valid e-mail address</p>';
		
		echo json_encode($response);
	}
	else {
		mysql_connect("localhost", "a8227339_sdeneen", "fertile5") or die(mysql_error());
		mysql_select_db("a8227339_dbase") or die(mysql_error());

		$strSQL = "INSERT INTO emails(";
		$strSQL = $strSQL . "email) ";
		$strSQL = $strSQL . "VALUES(";
		$strSQL = $strSQL . "'" . $email . "')";

		mysql_query($strSQL) or die(mysql_error());

		mysql_close();

		$response = array();
		$response['status'] = 1;	
		$response['html'] = '<p>Thank you. You have successfully registered your email to receive news from us!</p>';
		
		echo json_encode($response);
	
	}

?>