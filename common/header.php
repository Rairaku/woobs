<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />  

    <title>WolvesOfOld Blade & Soul Clan Page | <?php echo $pageTitle ?></title>

    <!--<link rel="stylesheet" href="style.css" type="text/css" />-->
    <!--<link rel="stylesheet" href="/css/forms.css" type="text/css" />-->
    <!--<link rel="stylesheet" href="/css/header.css" type="text/css" />-->
    <!--<link rel="stylesheet" href="/css/lists.css" type="text/css" />-->
    <!--<link rel="stylesheet" href="/css/messaging.css" type="text/css" />-->
    <!--<link rel="stylesheet" href="/css/reset.css" type="text/css" />-->
    <!--<link rel="stylesheet" href="/css/structure.css" type="text/css" />-->
    <!--<link rel="stylesheet" href="/css/typography.css" type="text/css" />-->
    <!-- Bootstrap core CSS -->
    <link rel="stylesheet" href="/css/bootstrap.min.css" type="text/css" />
    <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
    <link rel="stylesheet" href="/css/ie10-viewport-bug-workaround.css" type="text/css" />
    <!-- Custom styles for this template -->
    <link rel="stylesheet" href="/css/sidebar.css" type="text/css" />
    <link rel="stylesheet" href="/css/main.css" type="text/css" />
    <script src="https://www.skypeassets.com/i/scom/js/skype-uri.js"></script>
    <link rel="shortcut icon" type="image/x-icon" href="/images/favicon.ico" />
</head>

<body>

    <div id="page-wrap">


        <div id="header">
            
            <nav class="navbar navbar-inverse navbar-fixed-top">
              <div class="container">
                    <div class="navbar-header">
                          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
                            <span class="sr-only">Toggle navigation</span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                          </button>
                      <a class="navbar-brand" href="/index.php">WolvesOfOld</a>
                    </div>
                    <div id="navbar" class="collapse navbar-collapse">
                      <ul class="nav navbar-nav">
                        <li><a href="/index.php">Home</a></li>
                        <li><a href="/about.php">About</a></li>
                        <li><a href="/contact.php">Contact</a></li>
                        <?php
                            if(isset($_SESSION['LoggedIn']) && isset($_SESSION['Username']) && isset($_SESSION['Email']) && $_SESSION['LoggedIn']==1):
                        ?>
                        <li><a href="/logout.php">Log Out</a></li>
                        <li><a href="/account.php">Your Account</a></li>
                        <?php else: ?>
                        <li><a href="/signup.php">Sign Up</a></li>
                        <li><a href="/login.php">Log In</a></li>
                        <?php endif; ?>
                      </ul>
                    </div><!--/.nav-collapse -->
                </div>
            </nav>

        </div>