<?php

#some stuff going on here

        
    include('db_connection.php');
    
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
    }
        
        
#some stuff going on here

?>
