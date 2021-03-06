<?php
    require_once 'vendor/autoload.php';
    include_once "common/base.php";
    $pageTitle = "Log In";
    include_once "common/header.php";
?>
    <div class="container">

<?php
    if(!empty($_SESSION['LoggedIn']) && !empty($_SESSION['Username']) && !empty($_SESSION['Email'])):
?>
 
        <p>You are currently <strong>logged in.</strong></p>
        <p><a href="/logout.php">Log out</a></p>
<?php
    elseif(!empty($_POST['u']) && !empty($_POST['p'])):
        include_once 'inc/class.users.inc.php';
        $users = new WoobsUsers($db);
        if($users->accountLogin()===TRUE):
            echo "<meta http-equiv='refresh' content='0;/'>";
            exit;
        else:
?>
            <h2>Login Failed&mdash;Try Again?</h2>
            <form class="form-horizontal" method="post" role="form" action="login.php" name="loginform" id="loginform">
                <div class="form-group">
                    <div class="col-xs-4">
                        <label for="u">Email Address or Username</label>
                        <input type="text" class="form-control" id="u" name="u" placeholder="Email/Username">
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-xs-4">
                        <label for="p">Password</label>
                        <input type="password" class="form-control" id="p" name="p" placeholder="Password">
                    </div>
                </div>
                <button type="submit" class="btn btn-success" name="login" id="login">Log In</button>
            </form>
            
            <br>
            
            <p><a href="/password.php">Did you forget your password?</a></p>
<?php
        endif;
    else:
?>
        <h2>Your clan awaits...</h2>
        <form class="form-horizontal" method="post" role="form" action="login.php" name="loginform" id="loginform">
            <div class="form-group">
                <div class="col-xs-4">
                    <label for="u">Email Address or Username</label>
                    <input type="text" class="form-control" id="u" name="u" placeholder="Email/Username">
                </div>
            </div>
            <div class="form-group">
                <div class="col-xs-4">
                    <label for="p">Password</label>
                    <input type="password" class="form-control" id="p" name="p" placeholder="Password">
                </div>
            </div>
            <button type="submit" class="btn btn-success" name="login" id="login">Log In</button>
        </form>
        
        <br>
        
        <p><a href="/password.php">Did you forget your password?</a></p>
<?php
    endif;
?>
 
        <div style="clear: both;"></div>
    </div><!-- /.container -->
<?php
    // include_once "common/ads.php";
    // include_once "common/close.php";
?>