<?php
    require_once 'vendor/autoload.php';
    include_once "common/base.php";
    if(isset($_SESSION['LoggedIn']) && $_SESSION['LoggedIn']==1):
        $pageTitle = "Your Account";
        include_once "common/header.php";
        include_once 'inc/class.users.inc.php';
        $users = new ColoredListsUsers($db);
 
        if(isset($_GET['e']) && $_GET['e']=="changed")
        {
            echo "<div class='message good'>Your email address "
                . "has been changed.</div>";
        }
        else if(isset($_GET['e']) && $_GET['e']=="failed")
        {
            echo "<div class='message bad'>There was an error "
                . "changing your email address.</div>";
        }
 
        if(isset($_GET['p']) && $_GET['p']=="changed")
        {
            echo "<div class='message good'>Your password "
                . "has been changed.</div>";
        }
        elseif(isset($_GET['p']) && $_GET['p']=="nomatch")
        {
            echo "<div class='message bad'>The two passwords "
                . "did not match. Try again!</div>";
        }
 
        if(isset($_GET['d']) && $_GET['d']=="failed")
        {
            echo "<div class='message bad'>There was an error "
                . "deleting your account.</div>";
        }
 
        list($userID, $v) = $users->retrieveAccountInfo();
?>
        <div class="container">
            <h2>Your Account</h2>
            <form class="form-horizontal" method="post" role="form" action="db-interaction/users.php" name="changeusernameform" id="changeusernameform">
                <input type="hidden" name="uid" value="<?php echo $userID ?>" />
                <input type="hidden" name="action" value="changeusername" />
                <div class="form-group">
                    <div class="col-xs-4">
                        <label for="u">Change Username</label>
                        <input type="text" class="form-control" id="u" name="u" placeholder="Email">
                    </div>
                </div>
                <button type="submit" class="btn btn-warning" id="change-username-submit" name="change-username-submit">Change Username</button>
            </form>
            
            <br />
            
            <form class="form-horizontal" method="post" role="form" action="db-interaction/users.php" name="changeemailform" id="changeemailform">
                <input type="hidden" name="uid" value="<?php echo $userID ?>" />
                <input type="hidden" name="action" value="changeemail" />
                <div class="form-group">
                    <div class="col-xs-4">
                        <label for="e">Change Username</label>
                        <input type="text" class="form-control" id="e" name="e" placeholder="Email">
                    </div>
                </div>
                <button type="submit" class="btn btn-warning" id="change-email-submit" name="change-email-submit">Change Email</button>
            </form>
            
            <br />
            
            <form class="form-horizontal" method="post" role="form" action="db-interaction/users.php" name="changepasswordform" id="changepasswordform">
                <input type="hidden" name="uid" value="<?php echo $userID ?>" />
                <input type="hidden" name="v" value="<?php echo $v ?>" />
                <input type="hidden" name="action" value="changepassword" />
                <div class="form-group">
                    <div class="col-xs-4">
                        <label for="p">New Password</label>
                        <input type="password" class="form-control" id="p" name="p" placeholder="Password">
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-xs-4">
                        <label for="r">Re-type New Password</label>
                        <input type="password" class="form-control" id="r" name="r" placeholder="Re-type Password">
                    </div>
                </div>
                <button type="submit" class="btn btn-warning" id="change-password-submit" name="change-password-submit">Change Password</button>
            </form>
            
            <hr />
            
            <form class="form-horizontal" method="post" role="form" action="db-interaction/users.php" name="deleteaccountform" id="deleteaccountform">
                <input type="hidden" name="uid" value="<?php echo $userID ?>" />
                <input type="hidden" name="action" value="deleteaccount" />
                <button type="submit" class="btn btn-danger" id="delete-account-submit" name="delete-account-submit">Delete Account?</button>
            </form>
        </div><!-- /.container -->
<?php
    else:
        header("Location: /");
        exit;
    endif;
?>
 
    <div class="clear"></div>
 
<?php
    // include_once "common/ads.php";
    // include_once "common/close.php";
?>