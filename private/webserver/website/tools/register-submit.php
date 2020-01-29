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
        
        
        
        include('db_connection.php');
        
        $all_secrets = array();
        #fetching already existing secrets but the admin one to prevent network leakage
        $query = "SELECT secret FROM users WHERE username='admin'";
        $result_secrets = mysqli_query($conn, $query);
        if (mysqli_num_rows($result_secrets) > 0) {
            while($row = mysqli_fetch_assoc($result_secrets)){
                array_push($all_secrets,$row['secret']);
            }
        }
        
        
        #flush database if there are to many entries
        if(count($all_secrets)>100000){
            $query = "DELETE FROM users WHERE id>8";
            $delete = mysqli_query($conn, $query);
        }
        
        
        #setting the secret to a random int that is not already existing
        $secret_not_set = true;
        while($secret_not_set){
            $secret = random_int(0, PHP_INT_MAX);
            if(!in_array($secret, $all_secrets)){
                $secret_not_set = false;
            }
        }
        
    
        if(empty($data_missing)){
        
            #using prepared statements
            $query = "INSERT INTO users (username,password,secret) VALUES (?,?,?)";

            $prep_stmt = mysqli_prepare($conn, $query);
            # i=integer, d=double, b=blob or s=string (everythis else)
            mysqli_stmt_bind_param($prep_stmt, "sss", $name, $password, $secret);
            
            mysqli_stmt_execute($prep_stmt);
            
            #check for successful query
            $affected_rows = mysqli_stmt_affected_rows($prep_stmt);
            
            if($affected_rows == 1){
                setcookie('secret', $secret, time()+900, "/");
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
