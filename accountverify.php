<?php
    require_once 'vendor/autoload.php';
    include_once "common/base.php";
    $pageTitle = "Verify Your Account";
    include_once "common/header.php";
 
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
        $users->updateUsername();
        $ret = $users->updatePassword();
    }
    else
    {
        header("Location: /signup.php");
        exit;
    }
 
    if(isset($ret[0])):
        echo isset($ret[1]) ? $ret[1] : NULL;
 
        if($ret[0]<3):
?>
    <div class="container">
        <h2>Choose a Username and Password</h2>
        <form class="form-horizontal" method="post" role="form" action="accountverify.php" name="accountverifyform" id="accountverifyform">
            <div class="form-group">
                <div class="col-xs-4">
                    <label for="u">Choose a Username</label>
                    <input type="text" class="form-control" id="u" name="u" placeholder="Username">
                </div>
            </div>
            <div class="form-group">
                <div class="col-xs-4">
                    <label for="p">Choose a Password</label>
                    <input type="password" class="form-control" id="p" name="p" placeholder="Password">
                </div>
            </div>
            <div class="form-group">
                <div class="col-xs-4">
                    <label for="r">Re-Type Password</label>
                    <input type="password" class="form-control" id="r" name="r" placeholder="Re-Type Password">
                </div>
            </div>
          <input type="hidden" name="v" value="<?php echo $_GET['v'] ?>" />
          <button type="submit" class="btn btn-success" name="verify" id="verify">Verify Your Account</button>
        </form>
    </div><!-- /.container -->
<?php
        endif;
    else:
        echo '<meta http-equiv="refresh" content="0;/login.php">';
    endif;
 
    // include_once("common/ads.php");
    // include_once 'common/close.php';
?>