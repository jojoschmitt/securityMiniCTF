<?php
    require_once('tools/db_connection.php');

    $query = "SELECT username FROM users WHERE username='admin';";
    $response = @mysqli_query($conn, $query);
    
    if ($response){
        $row = mysqli_fetch_array($response);
        echo $row[0];
    } else {
        echo "There is no content in the database!";
        echo mysqli_error($conn);
        }
    mysqli_close($conn)
?>
