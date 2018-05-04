<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <title>Jobster Students Homepage</title>

    <!-- Bootstrap -->
    <link href="css/bootstrap.min.css" rel="stylesheet">

    <style>
        #topContainer
        {
            background-image: url("images/back.jpeg");
            height:975px;
            width:100%;
            background-size:cover;
        }
        #registerRow
        {
            margin-top:200px;
        }
        #registerform
        {
            margin-top:20px;
        }

        .whiteBackground
        {
            margin-right:10px;
            padding:20px;
            background-color: hsla(240, 20%, 95%, 0.8);
            border-radius: 20px;
        } 
    </style>
</head>
<body>

<nav class="navbar navbar-inverse navbar-fixed-top" id="topBar">
    <div class="container-fluid">
        <!-- Brand and toggle get grouped for better mobile display -->
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbarlink" aria-expanded="false">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
				<span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
        </div>

        <!-- Collect the nav links, forms, and other content for toggling -->
        <div class="collapse navbar-collapse" id="navbarlink">
            <ul class="nav navbar-nav ">
                <li class="active"><a href="index.php">Students<span class="sr-only">(current)</span></a></li>
                <li><a href="indexcompany.php">Companies</a></li>
				<!-- <li><a href="about.php">About</a></li>
                <li><a href="Developer.php">Developer</a></li> -->
            </ul>

            <form class="navbar-form navbar-right" method="post">
                <div class="form-group">
                    <input type="email" class="form-control" placeholder="Student Email" name="loginemail"/>
                </div>

                <div class="form-group">
                    <input type="password" class="form-control" placeholder="Password" name="loginpassword"/>
                </div>
                <input type="submit" class="btn btn-success" name="submit" value="Log in"/>
            </form>

        </div>
    </div>
</nav>



<div class="container" id="topContainer">
    <div class="row" id="registerRow">
        <div class="col-md-4 col-md-offset-1 whiteBackground" id="registerform">
			<h1> Student Register</h1>
            <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
      

                <div class="form-group">
                    <label for="registername">User Name:</label>
                    <input type="text" class="form-control" placeholder="User Name" name="registername" id="registername"/>
                </div>

                <div class="form-group">
                    <label for="registeremail">Email:(You will use it as login account)</label>
                    <input type="email" class="form-control" placeholder="Email" name="registeremail" id="registeremail"/>
                </div>

                <div class="form-group">
                    <label for="registerpassword">Password:</label>
                    <input type="password" class="form-control" placeholder="Password" name="registerpassword" id="registerpassword"/>
                </div>
                <input type="submit" class="btn btn-success" name="submit" value="signup"/>

            </form>

        </div>
    </div>
</div>


<?php
    require_once('connection.php');
    $dbc = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME) or die('db connection error #3');

    if (isset($_POST['submit']))
    {
        $registerName = mysqli_real_escape_string($dbc, trim($_POST['registername']));
        $registerPassword = mysqli_real_escape_string($dbc, trim($_POST['registerpassword']));
        $registerEmail = mysqli_real_escape_string($dbc, trim($_POST['registeremail']));
        // $password1 = mysqli_real_escape_string($dbc, trim($_POST['password1']));
        // $password2 = mysqli_real_escape_string($dbc, trim($_POST['password2']));

        if (!empty($registerName) && !empty($registerPassword) && !empty($registerEmail))
        {
            $query = 
            "SELECT * FROM Student " . 
            "WHERE student_email = '$registerEmail' ";

            $data = mysqli_query($dbc, $query);
            
            if (mysqli_num_rows($data) == 0)
            {
                # email is unique
                $query = 
                "INSERT INTO Student (student_name, student_password, student_email) " . 
                "VALUES ('$registerName', SHA('$registerPassword'), '$registerEmail'); ";
                mysqli_query($dbc, $query);
                echo '<p> Welcome to Jobster! ';
                echo 'You are now ready to log in. </p>';

                mysqli_close($dbc);
                exit();
            }
            else echo 'an account already exists';
        }
        else echo '<p> Critical data missing </p>';
    }
    mysqli_close();
?>


</body>
</html>

