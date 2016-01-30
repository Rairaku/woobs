<?php
    include_once "common/base.php";
 
    if(isset($_GET['v']) && isset($_GET['e']))
    {
        include_once "inc/class.users.inc.php";
        $users = new ColoredListsUsers($db);
        $ret = $users->verifyAccount();
    }
    elseif(isset($_POST['v']))
    {
        include_once "inc/class.users.inc.php";
        $users = new ColoredListsUsers($db);
        $status = $users->updatePassword() ? "changed" : "failed";
        header("Location: /account.php?p=$status");
        exit;
    }
    else
    {
        header("Location: /login.php");
        exit;
    }
 
    $pageTitle = "Reset Your Password";
    include_once "common/header.php";
 
    if(isset($ret[0])):
        echo isset($ret[1]) ? $ret[1] : NULL;
 
        if($ret[0]<3):
?>
    <div class="container">
        <h2>Reset Your Password</h2>
        
        <form class="form-horizontal" method="post" role="form" action="accountverify.php" name="forgetpasswordform" id="forgetpasswordform">
            <input type="hidden" name="action" value="resetpassword" />
            <div class="form-group">
                <div class="col-xs-4">
                    <label for="p">Choose a New Password</label>
                    <input type="password" class="form-control" id="p" name="p" placeholder="Password">
                </div>
            </div>
            <div class="form-group">
                <div class="col-xs-4">
                    <label for="r">Re-type Password</label>
                    <input type="password" class="form-control" id="r" name="r" placeholder="Re-type Password">
                </div>
            </div>
            <input type="hidden" name="v" value="<?php echo $_GET['v'] ?>" />
            <button type="submit" class="btn btn-success" id="verify" name="verify">Reset Password</button>
        </form>
    </div><!-- /.container -->
<?php
        endif;
    else:
        echo '<meta http-equiv="refresh" content="0;/">';
    endif;
 
    // include_once("common/ads.php");
    // include_once 'common/close.php';
?>