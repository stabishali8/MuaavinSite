<?php
    require('config.php');

    $connection = new mysqli($host,$username,$password,$database);
    if (!$connection)
    {
       die("Connection failed: " . mysqli_error($connection));
    }   
    $db_select= mysqli_select_db($connection,$database); 
    if(!$db_select)
    {
       die("error" . mysqli_error($db_select));  
    }
    $query = "SELECT * FROM twitter ORDER BY created_at DESC LIMIT 3";
    $result = mysqli_query($connection,$query);
    if(!$result)
    {
       die("invalid query".mysqli_error($result));
    }
    if($result->field_count){
        $event = $result->fetch_assoc();
        echo "<div class='item active'>";
        echo "<img src='img/twitter/twitter2.png' alt=''>";
        echo "<p>";
        echo $event["tweet"];
        echo "</p>";
        echo "<a href='#'>";
        echo $event["created_at"];
        echo "</a>";
        echo "</div>";
        while($row = $result->fetch_assoc()) {
                echo "<div class='item'>";
                echo "<img src='img/twitter/twitter3.png' alt=''>";
                echo "<p>";
                echo $row["tweet"];
                echo "</p>";
                echo "<a href='#'> ";
                echo $row["created_at"];
                echo "</a>";
                echo "</div>";
        }
    }    
?>
