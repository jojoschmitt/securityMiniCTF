<?php

#some stuff going on here

    #using prepared statements
    #BINARY operator for byte by byte comparison -> case sensitive query
    #query user information
    $prep_stmt_user = $conn->prepare("SELECT * FROM users WHERE BINARY secret=?"); 
    $prep_stmt_user->bind_param("s",$secret);
    $prep_stmt_user->execute();
    $response_user = $prep_stmt_user->get_result();
    
    #check query response
    $incorrect_cred = "Username, password or secret incorrect!</br>Please try again!</br></br>";
    
    if($response_user->num_rows === 0){
        echo $incorrect_cred;
        echo '<br/><a href="../index.php">Login</a>';
        echo '<br/><a href="../forgot-secret.php">What is my secret?</a>';
    } else {
        $response_user = $response_user->fetch_array();
        $response_username = $response_user['username'];
        $response_password = $response_user['password'];
        $response_secret = $response_user['secret'];
        
        if($name != $response_username || $password != $response_password || $secret != $response_secret){
            echo $incorrect_cred;
            echo '<br/><a href="../index.php">Login</a>';
            echo '<br/><a href="../forgot-secret.php">What is my secret?</a>';
        } else {
            #set cookie to be later able to change the correct password
            #(name, value, expire(in sec), path, domain, secure, httponly)
            setcookie('sessionID', $secret, time()+900, "/");
            
            #Welcome message
            echo "Welcome $name </br> Login successful!";
            echo '<meta http-equiv="Refresh" content="2; url=../main.php"/>';
        }
    }
            
#some stuff going on here            
            
?>
