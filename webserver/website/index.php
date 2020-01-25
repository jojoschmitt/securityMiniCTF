Here is the output of the test file: 
<?php
    include('tools/test_print.php');
?>

<br>
<br>


<html>
<head>
<title> Login </title>
</head>
<body>
<b>
Register
</b>
<form action="/tools/register.php" method ="post">

    <p> Name:
    <input type="text" name="name" size=30 value="" />
    </p>
    <p> Password:
    <input type="text" name="pw" size=30 value="" />
    </p>
    <p> Secret:
    <input type="text" name="sec" size=30 value="" />
    </p>
    
    <p>
        <input type="submit" name="submit" value="Register" />
    </p>
    
</form>


</body>
</html>

    
