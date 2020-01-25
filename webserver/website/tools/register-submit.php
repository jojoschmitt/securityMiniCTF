<?php

    if(isset($_POST['submit'])){
    
        $data_missing = array();
        if(empty($_POST['name'])){
            $data_missing[] = 'Name';
        } else {
        $name = trim($_POST['name']);
        }
        if(empty($_POST['pw'])){
            $data_missing[] = 'Password';
        } else {
        $password = trim($_POST['pw']);
        }
        if(empty($_POST['sec'])){
            $data_missing[] = 'Secret';
        } else {
        $secret = trim($_POST['sec']);
        }
        $sessionID = random_int(0, 999999);
    
    
        if(empty($data_missing)){
            include('db_connection.php');
            
            #using prepared statements
            $query = "INSERT INTO users (username,password,sessionID,secret) VALUES (?,?,?,?)";

            $prep_stmt = mysqli_prepare($conn, $query);
            # i=integer, d=double, b=blob or s=string (everythis else)
            mysqli_stmt_bind_param($prep_stmt, "ssss", $name, $password, $sessionID, $secret);
            
            mysqli_stmt_execute($prep_stmt);
            
            #check for successful query
            $affected_rows = mysqli_stmt_affected_rows($prep_stmt);
            
            if($affected_rows == 1){
                echo "You have been registered!";
                echo '<br/><br/><a href="../index.php">Login</a>';
                echo '<meta http-equiv="Refresh" content="1; url=../index.php"/>';
                mysqli_stmt_close($prep_stmt);
                mysqli_close($conn);
            } else {
                echo "Error on MySQL query occured!";
            }
        } else {
            echo "You did not provide all necessary fields!<br/>Please try again and provide the following fields:<br/>";
            foreach($data_missing as $data){
                echo "- $data<br/>";
            }
            echo '<br/><a href="../register.php">Register</a>';
            echo '<br/><a href="../index.php">Home</a>';
        }
    }

?>

<meta http-equiv="Refresh" content="6; url=../index.php"/>
