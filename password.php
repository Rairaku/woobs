<?php
    require_once 'vendor/autoload.php';
    include_once "common/base.php";
    $pageTitle = "Reset Your Password";
    include_once "common/header.php";
?>
    <div class="container">
        <h2>Reset Your Password</h2>
        <p>Enter the email address you signed up with and we'll send you a link to reset your password.</p>
        
        <form class="form-horizontal" method="post" role="form" action="db-interaction/users.php" name="forgetpasswordform" id="forgetpasswordform">
            <input type="hidden" name="action" value="resetpassword" />
            <div class="form-group">
                <div class="col-xs-4">
                    <label for="e">Email Address</label>
                    <input type="text" class="form-control" id="e" name="e" placeholder="Email">
                </div>
            </div>
            <button type="submit" class="btn btn-warning" id="reset" name="reset">Reset Password</button>
        </form>
    </div><!-- /.container -->
<?php
    // include_once "common/ads.php";
    // include_once "common/close.php";
?>