<?php 
    require_once 'vendor/autoload.php';
    include_once "common/base.php";
    $pageTitle = "Home";
    include_once "common/header.php"; 
?>
<div id="main">
    <noscript>This site just doesn't work, period, without JavaScript</noscript>
    <div class="container">

<?php
        if(isset($_SESSION['LoggedIn']) && isset($_SESSION['Username']) && isset($_SESSION['Email']) && $_SESSION['LoggedIn']==1):
?>
            <h2>Under Construction...</h2>
            <div id="BnSChat" style="width:20%;background-color:#0094ff">
                <script type="text/javascript">
                    Skype.ui({
                        name: "chat",
                        element: "BnSChat",
                        participants: ["reginlaff","yeongwonhi"],
                        listParticipants:true,
                        imageSize: 32,
                        imageColor: "white"
                    });
                </script>
            </div>
<?php else: ?>
            <h2>Please Sign Up or Log In!</h2>
            <img src="https://scontent-lax3-1.xx.fbcdn.net/hphotos-xpl1/v/t1.0-9/12565404_10153196569315933_995639197534309339_n.jpg?oh=1d979ed1d96adb189b279c6c0c296388&oe=5735DC56" class="img-responsive" alt="Responsive image">
<?php endif; ?>
    </div><!-- /.container -->
</div>

<?php include_once "common/sidebar.php"; ?>

<?php include_once "common/footer.php"; ?>
