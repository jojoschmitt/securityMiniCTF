<?php
    if(isset($_COOKIE)){
        setcookie('sessionID', "", time()-1, "/");
    }
?>

<meta http-equiv="Refresh" content="0; url=../index.php"/>
