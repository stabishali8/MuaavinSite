<?php
require("config.php");

$conn=mysqli_connect($host,$username,$password,$database);

// if(!$conn)
// {
// die('error' . mysqli_error($conn));
// }
    $db_selected = mysqli_select_db($conn,$database);
    if(!$db_selected)
    {
    die('error' .mysqli_error($db_selected));
    }
    if(isset($_POST['submit'])){
    // echo 'a';
    session_start();
    $name= mysqli_real_escape_string($conn,$_POST['name']);
    $email= mysqli_real_escape_string($conn,$_POST['email']);
    $comment=mysqli_real_escape_string($conn,$_POST['message']);
        $query="INSERT INTO contact_form (id,name,email,comment) VALUES(Null,'$name','$email','$comment')";
        $result = mysqli_query($conn,$query);
        if(!$result)
        {
            die('Invalid query: '. mysqli_error($result));
        }
    header('Location: ../responsePage.html');
    $conn->close();
    }
?>