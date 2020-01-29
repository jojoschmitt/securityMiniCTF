<?php
    if(!isset($_COOKIE['sessionID'])){
        echo '<meta http-equiv="Refresh" content="0; url=../index.php"/>';
        exit();
    }
?>




<html>
<title>Main</title>

<form action="tools/logout-submit.php" method ="post">

    <p>
        <input type="hidden" name="$username" value="$username" />
        <input type="submit" name="logout-submit" value="Logout" />
    </p>
    
</form>
    
    
<a href="/change_pw.php">Change password</a>
</html>
