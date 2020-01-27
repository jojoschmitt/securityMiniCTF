<?php

    if(isset($_POST['submit'])){
    
        $data_missing = array();
        if(empty($_POST['name'])){
            $data_missing[] = 'Name';
        } else {
            $name = trim($_POST['name']);
            #Deny access to admin account
            if($name == 'admin'){
                echo '<meta http-equiv="Refresh" content="0; url=register-admin.php"/>';
                exit();
            }
        }
        if(empty($_POST['pw'])){
            $data_missing[] = 'Password';
        } else {
            $password = trim($_POST['pw']);
        }
        $secret = random_int(0, 999999);
        #sessionID may be removed
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
                echo "You have been registered!<br/>";
                echo "Please provide this secret on every login: <b>$secret</b>";
                echo '<br/><br/><a href="../index.php">Login</a>';
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
            echo '<meta http-equiv="Refresh" content="6; url=../index.php"/>';
        }
    }

?>
