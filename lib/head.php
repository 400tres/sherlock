<!DOCTYPE html>
<html>

<head>
    <title>Sherlock</title>
    <link rel="shortcut icon" href="img/favicon3.png">
    <meta http-equiv="content-type" content="text/html;charset=utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta property="og:type" content="website">
    <meta property="og:title" content="Sherlock">
    <meta property="og:description" content="Browser Fingerprint Authentication System">
    <meta property="og:image" content="http://try-sherlock.com/img/logo_wide.png">
    <meta property="og:url" content="http://try-sherlock.com/">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <link href="https://fonts.googleapis.com/css?family=Montserrat" rel="stylesheet" type="text/css">
    <link href="css/font-awesome-4.6.3/css/font-awesome.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Assistant:300,600,800" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet" media="screen">
    <link href="css/login-signup.css" rel="stylesheet" media="screen">
    <link href="https://fonts.googleapis.com/css?family=Lato" rel="stylesheet" type="text/css">
    <script src="https://code.jquery.com/jquery.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <script src="js/fingerprint2.js"></script>
    <script src="js/sha256.js"></script>
</head>

<body id="myPage" data-spy="scroll" data-target=".navbar" data-offset="60">
<img src="img/background.jpg" class="bg" alt="">

    <nav class="navbar navbar-fixed-top">
    <!-- <nav class="navbar navbar-default navbar-fixed-top"> -->
        <div class="container">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>

                <a class="navbar-brand" href="index.php" style="font-family:'Assistant',Helvetica; font-weight: 600; font-size: 25px;">Sherlock</a>
            </div>

            <div class="collapse navbar-collapse" id="myNavbar">
                <ul class="nav navbar-nav navbar-right">
                    <?php
                        if(isset($_SESSION['is_login']) && $_SESSION['is_login'] === true) {
                            echo '<li><a href="mypage.php">My Page</a></li>';
                            echo '<li><a href="lib/logout.php">Logout</a></li>';
                        }
                        else {
                            echo '<li><a href="login.php">Sign In</a></li>';
                            echo '<li><a href="signup.php">Sign Up</a></li>';
                        }
                    ?>
                </ul>
            </div>
        </div>
    </nav>
