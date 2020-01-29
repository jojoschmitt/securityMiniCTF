<?php

    #checking if the visitor is logged in
    if(!isset($_COOKIE['sessionID'])){
        echo '<meta http-equiv="Refresh" content="0; url=../index.php"/>';
        exit();
    }


    if(isset($_POST['submit'])){
    
        #just checking if all password field were provided
        #if not, save all fields not provided in data_missing
        $data_missing = array();
        if(empty($_POST['oldpw'])){
            $data_missing[] = 'Old password';
        } else {
            $oldpw = trim($_POST['oldpw']);
            }
        if(empty($_POST['npw'])){
            $data_missing[] = 'New password';
        } else {
            $newpw = trim($_POST['npw']);
        }
        if(empty($_POST['cpw'])){
            $data_missing[] = 'Confirm password';
        } else {
            $confirmpw = trim($_POST['cpw']);
        }
    
        
        #if all fields have been provided continues updating DB
        if(empty($data_missing)){ 

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
            #blacklist illegal words in username
            $dangerous_word = array('drop','delete','update','alter','admin','insert','like');
            foreach($dangerous_word as $word){
                #using case insensitive comparison because of MySQL queries
                if(strcasecmp($username,$word) == 0){
                    echo 'Sorry, your username is dangerous.<br>Please register a new account!<br>';
                    echo '<meta http-equiv="Refresh" content="3; url=../main.php"/>';
                    exit();
                }
            }
            
            
            #the secret may only be an integer
            if(!is_numeric($secret)){
                echo "Did you just change the cookie? Nananana!!";
                if(isset($_COOKIE)){
                    setcookie('sessionID', "", time()-1, "/");
                }
                echo '<meta http-equiv="Refresh" content="2; url=../index.php"/>';
                exit();
            }
            
            
            #loading stored password for comparison
            #we tested this thoroughly, it is save!
            $response_user = $conn->query("SELECT * FROM users WHERE BINARY secret='$secret' && BINARY username='$username'");
            $response_user = $response_user->fetch_array();
            $old_saved_password = $response_user['password'];
            $secret = $response_user['secret'];
            echo "Login for sessionID $secret in progress...<br><br>";
            
            
            
            #check if new and confirm password are the same and if the old one matches
            if($oldpw != $old_saved_password || $newpw != $confirmpw){
                echo "The confirmation password does not match the new password or your old password is incorrect!<br>Please try again.";
                echo '<meta http-equiv="Refresh" content="5; url=../change_pw.php"/>';
                echo '<br><br><a href="../change_pw.php">Change password!</a>';
                exit();
            }
            
            
            
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
            
        #if not all fields were provided inform the user
        } else {
            echo "You did not provide all necessary fields!<br/>Please try again and provide the following fields:<br/>";
            foreach($data_missing as $data){
                echo "- $data<br/>";
            }
            echo '<br/><a href="../main.php">Home</a>';
            echo '<br/><a href="../change_pw.php">Change password!</a>';
        }
    }
    
?>

<!--automatic redirect-->
<meta http-equiv="Refresh" content="6; url=../change_pw.php"/>
