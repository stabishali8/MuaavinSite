<?php
require("config.php");

function parseToXML($htmlStr)
{
$xmlStr=str_replace('<','&lt;',$htmlStr);
$xmlStr=str_replace('>','&gt;',$xmlStr);
$xmlStr=str_replace('"','&quot;',$xmlStr);
$xmlStr=str_replace("'",'&#39;',$xmlStr);
$xmlStr=str_replace("&",'&amp;',$xmlStr);
return $xmlStr;
}

// Opens a connection to a MySQL server
$connection=mysqli_connect($host,$username,$password,$database);
if (!$connection) {
  die('Not connected : ' . mysqli_error($connection));
}

// Set the active MySQL database
$db_selected = mysqli_select_db($connection, $database);
if (!$db_selected) {
  die ('Can\'t use db : ' . mysqli_error($db_selected));
}

// Select all the rows in the markers table

$query = "select * from mvn_crowd_source_event WHERE reported_at > DATE_SUB(NOW(), INTERVAL 24 HOUR)";
$result = mysqli_query($connection,$query);
if (!$result) {
  die('Invalid query: ' . mysqli_error($result));
}

header("Content-type: text/xml");

// Start XML file, echo parent node
echo '<markers>';

// Iterate through the rows, printing XML nodes for each
while ($row = mysqli_fetch_array($result,MYSQLI_ASSOC)){
  // ADD TO XML DOCUMENT NODE
  echo '<marker ';
  echo 'place_name="' . parseToXML($row['place_name']) . '" ';
  echo 'lat="' . $row['place_latitude'] . '" ';
  echo 'lng="' . $row['place_longitude'] . '" ';
  echo 'type="' . $row['type'] . '" ';
  echo 'reported_at="' . $row['reported_at'] . '" ';

  echo '/>';
}

// End XML file
echo '</markers>';

?>
