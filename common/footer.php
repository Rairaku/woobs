      </div>

      <!-- Analytics here -->
      <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <script>window.jQuery || document.write('<script src="/js/jquery.min.js"><\/script>')</script>
    <script src="/js/bootstrap.min.js"></script>
    <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
    <script src="/js/ie10-viewport-bug-workaround.js"></script>
    <?php
        if(isset($_SESSION['LoggedIn']) && isset($_SESSION['Username']) && isset($_SESSION['Email']) && $_SESSION['LoggedIn']==1):
    ?>
    <script src="/phpfreechat-2.1.0/client/jquery.phpfreechat.min.js" type="text/javascript"></script>
    <script type="text/javascript">$('#BnSChat').phpfreechat({ serverUrl: '/phpfreechat-2.1.0/server' });</script>
    <?php endif; ?>
</body>

</html>