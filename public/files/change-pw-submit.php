<?php

#some stuff going on here


    include('db_connection.php');
    
    #using prepared statements
    #BINARY operator for byte by byte comparison -> case sensitive query
    $secret = $_COOKIE['sessionID'];

    $prep_stmt_user = $conn->prepare("SELECT * FROM users WHERE BINARY secret=?"); 
    $prep_stmt_user->bind_param("s",$secret);
    $prep_stmt_user->execute();
    $response_user = $prep_stmt_user->get_result();
    $response_user = $response_user->fetch_array();
    $username = $response_user['username'];
    
    
    
    #you never know, better check the username a second time
    #the username is often underestimated in security
    #blacklist illegal strings in username
    $dangerous_word = array('drop','delete','update','alter','admin','insert','like','id');
    foreach($dangerous_word as $word){
        #using case insensitive comparison because of MySQL queries
        if(stripos($username,$word) !== false){
            echo 'Sorry, your username is dangerous.<br>Please register a new account!<br>';
            echo '<meta http-equiv="Refresh" content="3; url=../main.php"/>';
            exit();
        }
    }
    
    
    #loading stored password for later comparison
    #we tested this thoroughly, it is save!
    $response_user = $conn->query("SELECT * FROM users WHERE BINARY secret='$secret' && BINARY username='$username'");
    $response_user = $response_user->fetch_array();
    $old_saved_password = $response_user['password'];
    $secret = $response_user['secret'];
    echo "Login for sessionID $secret in progress...<br><br>";
    
    
    
    #changing the password in the database   
    $query = "UPDATE users SET password=? WHERE secret=? AND username=?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param('sss', $newpw,$secret,$username);
    $result = $stmt->execute();

    
    if($result){
        echo "Your password has been changed successfully";
        echo '<meta http-equiv="Refresh" content="2; url=../main.php"/>';
    } else {
        $conn->error();
    }
            
        
#some stuff going on here
    
?>
