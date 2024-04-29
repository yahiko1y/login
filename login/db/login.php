<?php 
session_start(); 
include "db_conn.php";
echo '<pre>';
print_r($_POST);
echo '</pre>';

if (isset($_POST['uname']) && isset($_POST['password'])) {

	function validate($data){
       $data = trim($data);
	   $data = stripslashes($data);
	   $data = htmlspecialchars($data);
	   return $data;
	}

	$uname = validate($_POST['uname']);
	$pass = validate($_POST['password']);

	if (empty($uname)) {
		header("Location: ../index.php?error=User Name is required");
	    exit();
	}else if(empty($pass)){
        header("Location: ../index.php?error=Password is required");
	    exit();
	}else{
		$sql = "SELECT * FROM users WHERE user_name='$uname' AND password_='$pass'";
		echo "i have been here 1";
		$result = mysqli_query($conn, $sql);

		if (mysqli_num_rows($result) === 1) {
			$row = mysqli_fetch_assoc($result);
            if ($row['user_name'] === $uname && $row['password_'] === $pass) {
            	$_SESSION['user_name'] = $row['user_name'];
            	$_SESSION['email'] = $row['email'];
            	$_SESSION['user_id'] = $row['user_id'];
            	header("Location: ../home.php");
		        exit();
            }else{
				header("Location: ../index.php?error=Incorect User name or password 1");
		        exit();
			}
		}else{
			header("Location: ../index.php?error=Incorect User name or password 2");
	        exit();
		}
	}
	
}else{
	header("Location: ../index.php");
	exit();
}
