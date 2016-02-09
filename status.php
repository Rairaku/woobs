<?php
    require_once 'vendor/autoload.php';
    include_once "common/base.php";
    $pageTitle = "Approve/Deny";
    include_once "common/header.php";
 
    if(isset($_GET['v']) && isset($_GET['e'])):
        include_once "inc/class.users.inc.php";
        $users = new WoobsUsers($db);
        echo $users->sendVerificationEmail($_GET['e'],$_GET['v']);
    else:
        include_once "inc/class.users.inc.php";
        $users = new WoobsUsers($db);
        echo $users->sendDenyEmail($_GET['email']);
?>
    
        
<?php
    endif;
    //include_once 'common/close.php';
?>