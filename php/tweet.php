<?php 
    require('config.php');

    function cleanother($string){
        // $string = "RT @khalid_pk: Glimpses of charged parking near Sareena mobile market, #Karachi https://t.co/Ex9cJw7h0x";
        $regex = "/[^A-Za-z0-9@:\-]/";
        $regex1 = "@(https?://([-\w\.]+[-\w])+(:\d+)?(/([\w/_\.-]*(\?\S+)?[^\.\s])?).*$)@";
        $replaceKeyword = str_replace(array("#KhiAlerts"," https:�","#Khialerts","UPDATE:", "#Karachi","Video:"," @Khi_Alerts","RT","@KhiTraffic","@SheryS_Official"), "", $string);
        $replaceLinks = preg_replace($regex1, ' ', $replaceKeyword);
        $replaceAll = preg_replace($regex, ' ', $replaceLinks);
        return $replaceAll;
    }
                $conn = new mysqli($host,$username,$password,$database);
                if (!$conn)
                {
                   die("Connection failed: " . mysqli_error($conn));
                }   
                $db_select= mysqli_select_db($conn,$database); 
                if(!$db_select)
                {
                   die("error" . mysqli_error($db_select));  
                }
                $sql = "SELECT * FROM twitter ORDER BY created_at DESC LIMIT 10";
                $result = mysqli_query($conn,$sql);
                if(!$result)
                {
                   die("invalid query".mysqli_error($result));
                }
                while($row = $result->fetch_assoc()) {
                    echo "<p class='tweet_text'>";
                    echo cleanother($row["tweet"]);
                    // echo $row["tweet"]);
                    echo "</p><br/>";
                    echo "<p class='tweet_date'>";
                    $date = date_create($row["created_at"]);
                    echo date_format($date,'d/m/Y H:i:s');
                    echo "</p><br/>";
                    echo "<hr class='hr-tweet'/>";
               }
?>
