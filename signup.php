<?php
    require_once 'vendor/autoload.php';
    include_once "common/base.php";
    $pageTitle = "Register";
    include_once "common/header.php";

?>
    <div class="container">
<?php
    if(!empty($_POST['e'])):
        include_once "inc/class.users.inc.php";
        $users = new WoobsUsers($db);
        echo $users->approveAccount();
    else:
?>
        <h2>Sign up</h2>
        <form class="form-horizontal" method="post" action="signup.php" name="registerform" id="registerform">
            <div class="form-group">
                <div class="col-xs-4">
                    <label for="e">Email Address</label>
                    <input type="email" class="form-control" id="e" name="e" placeholder="Email">
                </div>
            </div>
            <button type="submit" class="btn btn-success" id="register" name="register">Sign Up</button>
        </form>
        
<?php
    endif;
    //include_once 'common/close.php';
?>
    </div><!-- /.container -->