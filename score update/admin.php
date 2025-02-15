<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<link rel="stylesheet" href=
"https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">
	<style>body {
	margin: 0;
	padding: 0;
	font-family: sans-serif;
	background: url('/homepage/score update/image/admin1.jpg') no-repeat;
	background-size: cover;
  background-position: center;/* Ensure the entire background image is visible */
  background-repeat: no-repeat; /* Prevent the background image from repeating */
  background-attachment: fixed;
}

.login-box {
	width: 280px;
	position: absolute;
	top: 50%;
	left: 50%;
	transform: translate(-50%, -50%);
	color: #191970;
}

.login-box h1 {
	float: left;
	font-size: 40px;
	border-bottom: 4px solid #191970;
	margin-bottom: 50px;
	padding: 13px;
}

.textbox {
	width: 100%;
	overflow: hidden;
	font-size: 20px;
	padding: 8px 0;
	margin: 8px 0;
	border-bottom: 1px solid #191970;
}

.fa {
	width: px;
	float: left;
	text-align: center;
}

.textbox input {
	border: none;
	outline: none;
	background: none;
	font-size: 18px;
	float: left;
	margin: 0 10px;
}

.button {
	width: 100%;
	padding: 8px;
	color: #ffffff;
	background: none #191970;
	border: none;
	border-radius: 6px;
	font-size: 18px;
	cursor: pointer;
	margin: 12px 0;
}

        </style>
	<title>Login Page</title>
    
</head>

<body>
	<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
		<div class="login-box">
			<h1> Admin Login</h1>

			<div class="textbox">
				<i class="fa fa-user" aria-hidden="true"></i>
				<input type="text" placeholder="Username"
						name="username" value="">
			</div>

			<div class="textbox">
				<i class="fa fa-lock" aria-hidden="true"></i>
				<input type="password" placeholder="Password"
						name="password" value="">
			</div>

			<input class="button" type="submit"
					name="login" value="Sign In">
		</div>
	</form>
</body>
<?php
    $dbConnection = mysqli_connect("localhost", "root", "", "admin_login") or die("Connection failed");

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $username = $_POST['username'];
        $password = $_POST['password'];
        
        // Use prepared statement to prevent SQL injection
        $q1 = "SELECT username, user_password FROM admin_login WHERE username=? AND user_password=?";
        $stmt = mysqli_prepare($dbConnection, $q1);
        mysqli_stmt_bind_param($stmt, "ss", $username, $password);
        mysqli_stmt_execute($stmt);
        $res3 = mysqli_stmt_get_result($stmt);
        
        if ($row3 = mysqli_fetch_assoc($res3)) {
            $user = $row3['username'];
            $pass = $row3['user_password'];
            
            if ($user == $username && $pass == $password) {
                mysqli_stmt_close($stmt);
                mysqli_close($dbConnection);
                header("Location: match.php?Username=$username");
                exit();
            } else {
                echo "error";
            }
        } else {
            echo "Invalid username or password";
        }}
    ?>

</html>
