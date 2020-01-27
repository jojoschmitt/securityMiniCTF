<?php


    if(isset($_POST['login-submit'])){
    
        $data_missing = array();
        if(empty($_POST['login-name'])){
            $data_missing[] = 'Name';
        } else {
            $name = trim($_POST['login-name']);
            #Deny access to admin account
            if($name == 'admin'){
                echo '<meta http-equiv="Refresh" content="0; url=login-admin.php"/>';
                #without this exit() the rest of the code would be executed faster than the new page could be loaded. This would lead to information leakage that can easily be captured with a script.
                exit();
            }
        }
        if(empty($_POST['login-pw'])){
            $data_missing[] = 'Password';
        } else {
            $password = trim($_POST['login-pw']);
        }
        if(empty($_POST['login-secret'])){
            $data_missing[] = 'Secret';
        } else {
            $secret = trim($_POST['login-secret']);
        }
    
    
        if(empty($data_missing)){            
            include('db_connection.php');
            
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
    
       } else {
            echo "You did not provide all necessary fields!<br/>Please try again and provide the following fields:<br/>";
            foreach($data_missing as $data){
                echo "- $data<br/>";
            }
            echo '<br/><a href="../index.php">Login</a>';
            echo '<br/><a href="../forgot-secret.php">What is my secret?</a>';
        }
    }

?>

<meta http-equiv="Refresh" content="6; url=../index.php"/>
