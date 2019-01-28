<?php 
	session_start();

	// variable declaration
	$username = "";
	$email    = "";
	$errors = array(); 
	$_SESSION['success'] = "";

	// connect to database
	include_once('dbConfig.php');

	// REGISTER USER
	if (isset($_POST['reg_user'])) {
		// receive all input values from the form
		$username = mysqli_real_escape_string($db, $_POST['username']);
		$email = mysqli_real_escape_string($db, $_POST['email']);
		$password_1 = mysqli_real_escape_string($db, $_POST['password_1']);
		$password_2 = mysqli_real_escape_string($db, $_POST['password_2']);

		$query = "SELECT * FROM users WHERE username='$username'";
		$results = mysqli_query($db, $query);
		$query_email = "SELECT * FROM users WHERE email='$email'";
		$results_email = mysqli_query($db, $query_email);
		
		// form validation: ensure that the form is correctly filled
		if (empty($username)) { array_push($errors, "Username is required"); }
		if (empty($email)) { array_push($errors, "Email is required"); }
		if (empty($password_1)) { array_push($errors, "Password is required"); }
		if (mysqli_num_rows($results) > 0) {
			array_push($errors, "Username already exists.");
		}
		else if (mysqli_num_rows($results_email) > 0) {
			array_push($errors, "Email id already exists.");
		}
		if ($password_1 != $password_2) {
			array_push($errors, "The two passwords do not match");
		}

		// register user if there are no errors in the form
		if (count($errors) == 0) {
			$password = md5($password_1);//encrypt the password before saving in the database
			$query = "INSERT INTO users (username, email, password) 
					  VALUES('$username', '$email', '$password')";
			mysqli_query($db, $query);

			$_SESSION['username'] = $username;
			$_SESSION['success'] = "You are now logged in";
			header('location: login.php');
		}
	}


	// LOGIN USER
	if (isset($_POST['login_user']))
	{
		$username = mysqli_real_escape_string($db, $_POST['username']);
		$password = mysqli_real_escape_string($db, $_POST['password']);
		if (empty($username)) {
			array_push($errors, "Username is required");
		}
		
		if (empty($password)) {
			array_push($errors, "Password is required");
		}

		if (count($errors) == 0)
		{
			$password = md5($password);
			$query = "SELECT * FROM users WHERE username='$username' AND password='$password'";
			$results = mysqli_query($db, $query);

			if (mysqli_num_rows($results) == 1)
			{
				$_SESSION['username'] = $username;
				$_SESSION['success'] = "You are now logged in";
				header('location: index.php');
			}else {
				array_push($errors, "Wrong username/password combination");
			}
		}
	}

	// Receive the comments
	if (isset($_POST['commented']))
	{
		$title = mysqli_real_escape_string($db, $_POST['title']);
		$comments = mysqli_real_escape_string($db, $_POST['comments']);
		$venue = mysqli_real_escape_string($db, $_POST['venue']);
		$date1 = mysqli_real_escape_string($db, $_POST['date1']);
		$time1 = mysqli_real_escape_string($db, $_POST['time1']);
		$text1=$_SESSION['username'];
		$query = "INSERT INTO event (event_username ,event_name , event_desc , event_date , time , venue ) VALUES ('$text1' , '$title' , '$comments' ,'$date1' , '$time1' , '$venue') ";
		mysqli_query($db, $query);
		$_SESSION['success'] = "Successfully added event ";
		header('location: index.php');
	}

	// status1 updation by admin
	if (isset($_POST['approve1']))
	{
		$eve = mysqli_real_escape_string($db, $_POST['eventId']);
	    $query_approve = "UPDATE event SET status1='Approved' WHERE event_id = '$eve' ";
	    mysqli_query($db , $query_approve);
	    $_SESSION['success'] = "Event Approved Successfully";
		header('location: admin.php');
	}
	else if (isset($_POST['discard1']))
	{
	    $eve = mysqli_real_escape_string($db, $_POST['eventId']);
	    $query_discard = "UPDATE event SET status1='Discarded' WHERE event_id = '$eve' ";
	    mysqli_query($db , $query_discard);
	    $_SESSION['success'] = "Event Discarded";
		header('location: admin.php');
	}
	
	// Joining the event 
	if (isset($_POST['join11']))
	{
		$joi = mysqli_real_escape_string($db, $_POST['joinId']);
		$joinUser = mysqli_real_escape_string($db, $_POST['joinUser']);
	    $query_join = "INSERT INTO eventJoin (event_id , username , status2) VALUES ('$joi' , '$joinUser' , 'Joined')";
	   	$query_check = "UPDATE eventJoin SET status2='Joined' WHERE event_id = '$joi' AND username ='$joinUser' ";
	    mysqli_query($db , $query_join);
	    mysqli_query($db , $query_check);
	    $_SESSION['success'] = "Successfully joined the event ";
		header('location: broadcast.php');
	}

	// Leave the event 
	if (isset($_POST['leave11']))
	{
		$joi = mysqli_real_escape_string($db, $_POST['leaveId']);
		$joinUser = mysqli_real_escape_string($db, $_POST['leaveUser']);
	    $query_leave = "UPDATE eventJoin SET status2='Join1' WHERE event_id = '$joi' AND username = '$joinUser'";
	    mysqli_query($db , $query_leave);
	    $_SESSION['success'] = "You left the event Successfully";
		header('location: joined.php');
	}
?>
