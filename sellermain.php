<?php 
//ini_set('session.cache_limiter','public');
//session_cache_limiter(false);
session_start(); 
header('Cache-Control: max-age=900');
?>
<html>
<head>
    <!--
    <script src="js/jquery-1.12.4.min.js"></script>        
    <script>
    jQuery(document).ready(function($) {
    if (window.history && window.history.pushState) {
    window.history.pushState('forward', null, './#forward');
    $(window).on('popstate', function() {
          if( confirm('May I Close this window') ){
            top.close();
        }
        });
      }
    });
    </script>
    -->
</head>
<body style='margin:0;'>
<?php
$sellerid=$_SESSION["sellerid"];
$isMobile=is_numeric(strpos(strtolower($_SERVER['HTTP_USER_AGENT']), "mobile"));
echo "<iframe src='sellerhomeedit.php' width='100%' height='100%' style='border:none;'></iframe>"; 
//echo "<iframe src='sellerfooteredit.php?sellerid=$sellerid' width='100%' height='10%' style='border:none;'></iframe>"; 

?>
</body>    
</html>
