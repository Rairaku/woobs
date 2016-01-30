<?php
    include_once "common/base.php";
    $pageTitle = "Register";
    include_once "common/header.php";
 
    if(!empty($_POST['email'])):
        require 'vendor/autoload.php';
        include_once "inc/class.users.inc.php";
        $users = new ColoredListsUsers($db);
        echo $users->createAccount();
    else:
?>
    <div class="container">
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
    </div><!-- /.container -->
        
<?php
    endif;
    //include_once 'common/close.php';
?>