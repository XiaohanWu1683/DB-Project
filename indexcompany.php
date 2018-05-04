<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <title>Jobster Company Homepage</title>

    <!-- Bootstrap -->
    <link href="css/bootstrap.min.css" rel="stylesheet">

    <style>

        #topContainer
        {
            background-image: url("images/companyback.jpg");
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
				<li><a href="index.php">Students</a></li>
                <li class="active"><a href="indexcompany.php">Companies<span class="sr-only">(current)</span></a></li>
				<!-- <li><a href="about.php">About</a></li>
                <li><a href="Developer.php">Developer</a></li> -->
            </ul>
			
            <form class="navbar-form navbar-right" method="post">
                <div class="form-group">
                    <input type="email" class="form-control" placeholder="Company Email" name="logincompanyemail"/>
                </div>

                <div class="form-group">
                    <input type="password" class="form-control" placeholder="Password" name="logincompanypassword"/>
                </div>
                <input type="submit" class="btn btn-success" name="submit" value="Log in"/>
            </form>

        </div>
    </div>
</nav>



<div class="container" id="topContainer">
    <div class="row" id="registerRow">
        <div class="col-md-4 col-md-offset-1 whiteBackground" id="registerform">
		<h1> Company Register</h1>
            <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">

                <div class="form-group">
                    <label for="registercompanyname">Company Name:</label>
                    <input type="text" class="form-control" placeholder="Company Name" name="registercompanyname" id="registercompanyname"/>
                </div>

                <div class="form-group">
                    <label for="registercompanyemail">Email:(You will use it as login account)</label>
                    <input type="email" class="form-control" placeholder="Email" name="registercompanyemail" id="registercompanyemail"/>
                </div>

                <div class="form-group">
                    <label for="registercompanypassword">Password:</label>
                    <input type="password" class="form-control" placeholder="Password" name="registercompanypassword" id="registercompanypassword"/>
                </div>
				
				<div class="form-group">
                    <label for="registercompanylocation">Company Location:</label>
                    <input type="text" class="form-control" placeholder="Company Location" name="registercompanylocation" id="registercompanylocation"/>
                </div>
				
				<div class="form-group">
                    <label for="registercompanyindustry">Company Industry:</label>
                    <input type="text" class="form-control" placeholder="Company Industry" name="registercompanyindustry" id="registercompanyindustry"/>
                </div>
				
                <input type="submit" class="btn btn-success" name="submit" value="Sign up"/>

            </form>

        </div>
    </div>
</div>




<?php
    echo '<p> php script green #1 </p>'; ////
    require_once('connection.php');
    $dbc = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);

    if (isset($_POST['submit']))
    {
        echo '<p> submit form green #2 </p>'; //// 

        $registerCompanyName = mysqli_real_escape_string($dbc, trim($_POST['registercompanyname']));
        $registerCompanyPassword = mysqli_real_escape_string($dbc, trim($_POST['registercompanypassword']));
        $registerCompanyEmail = mysqli_real_escape_string($dbc, trim($_POST['registercompanyemail']));
        $registerCompanyLocation = mysqli_real_escape_string($dbc, trim($_POST['registercompanylocation']));
        $registerCompanyIndustry = mysqli_real_escape_string($dbc, trim($_POST['registercompanyindustry']));

        if (!empty($registerCompanyName) && !empty($registerCompanyPassword) && !empty($registerCompanyEmail) && !empty($registerCompanyLocation) && !empty($registerCompanyIndustry) )
        {
            $query = 
            "SELECT company_id FROM Company " . 
            "WHERE company_id = '$registerCompanyEmail'; ";

            $data = mysqli_query($dbc, $query);
            
            if (mysqli_num_rows($data) == 0)
            {
                # email is unique
                $query = 
                "INSERT INTO Company (company_name, company_password, company_email, company_location, industry) " . 
                "VALUES ('$registerCompanyName', SHA('$registerCompanyPassword'), '$registerCompanyEmail', '$registerCompanyLocation', '$registerCompanyIndustry'); ";
                
                echo $query;
                
                mysqli_query($dbc, $query);

                echo '<p> Welcome to Jobster! ';
                echo 'You are now ready to log in. </p>';

                mysqli_close($dbc);
                exit();
            }
            else echo 'an account already exists';
        }
        else echo '<p> Critical data missing #3 </p>';
    }
    mysqli_close();

?>




</body>
</html>

