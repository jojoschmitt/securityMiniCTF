<?php


    if(isset($_POST['login-submit'])){
    
        $data_missing = array();
        if(empty($_POST['login-name'])){
            $data_missing[] = 'Name';
        } else {
        $name = trim($_POST['login-name']);
        }
        if(empty($_POST['login-pw'])){
            $data_missing[] = 'Password';
        } else {
        $password = trim($_POST['login-pw']);
        }
    
    
        if(empty($data_missing)){
            include('db_connection.php');
            
            #using prepared statements
            #query username
            $prep_stmt_username = $conn->prepare("SELECT * FROM users WHERE username=?"); 
            $prep_stmt_username->bind_param("s",$name);
            $prep_stmt_username->execute();
            $response_username = $prep_stmt_username->get_result();
            #query password
            $prep_stmt_password = $conn->prepare("SELECT 'password' FROM users WHERE password=?"); 
            $prep_stmt_password->bind_param("s",$password);
            $prep_stmt_password->execute();
            $response_password = $prep_stmt_password->get_result();
            
            if($response_username->num_rows === 0 || $response_password->num_rows === 0){
                echo "Username or password incorrect!</br>Please try again!";
                echo '<br/><a href="../index.php">Login</a>';
            } else {
                $row = $response_username->fetch_array()['username'];
                echo "Welcome $row </br> Login successful!";
                echo '<meta http-equiv="Refresh" content="2; url=../main.php"/>';
            }
    

       } else {
            echo "You did not provide all necessary fields!<br/>Please try again and provide the following fields:<br/>";
            foreach($data_missing as $data){
                echo "- $data<br/>";
            }
            echo '<br/><a href="../index.php">Login</a>';
        }
    }

?>

<meta http-equiv="Refresh" content="6; url=../index.php"/>
