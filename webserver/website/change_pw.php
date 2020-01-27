<?php
    if(!isset($_COOKIE['sessionID'])){
        echo '<meta http-equiv="Refresh" content="0; url=../index.php"/>';
        exit();
    }
?>

<title>Change password</title>
<b>
Change your password here:
</b>
<form action="/tools/change-pw-submit.php" method ="post">

    <p> Old password:<br>
    <input type="text" name="oldpw" size=30 value="" />
    </p>
    <p> New password:<br>
    <input type="text" name="npw" size=30 value="" />
    </p>
    <p> Confirm new password:<br>
    <input type="text" name="cpw" size=30 value="" />
    </p>
    
    <p>
        <input type="submit" name="submit" value="Submit" />
    </p>
    
</form>

<br/><a href="../index.php">Home</a>
