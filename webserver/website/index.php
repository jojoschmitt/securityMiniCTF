<html>
<head>
<title> Login </title>
</head>
<body>


<form action="tools/login-submit.php" method ="post">

    <p> Name:<br>
    <input type="text" name="login-name" size=30 value="" />
    </p>
    <p> Password:<br>
    <input type="text" name="login-pw" size=30 value="" />
    </p>
    <p> Secret:<br>
    <input type="text" name="login-secret" size=30 value="" />
    </p>
    
    <p>
        <input type="submit" name="login-submit" value="Login" />
    </p>
    
</form>


<br>


<a href="register.php">Register</a>
<br>
<a href="../forgot-secret.php">What is my secret?</a>

<br><br><br>


<p>
    <b> Warning: </b> The engineeers noticed a power shortage in the base.
    <br> This will lead to a system reset every 15 minutes, they said.
</p>


</body>
</html>

<!--If the user has already logged in,redirect to main.php-->
<?php
    if(isset($_COOKIE['sessionID'])){
        echo '<meta http-equiv="Refresh" content="0; url=main.php"/>';
    }
?>

    
