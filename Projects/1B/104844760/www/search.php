<html>
<head>
  <title>Search</title>
  <base href="." target="_blank">
  <meta name="description" content="Search">
  <meta name="author" content="Yuhai Li">
  <meta name="viewpoint" content="width=device-width, initial-scale=1.0">
</head>  
<body>
<p><a href="./home.php">Home</a></p>
<form method="GET" action="./search.php">
  Search:<input type="text" name="name">
  <br></br>
</form>

<?php
// get name
$name = $_GET["name"];
if($name) {
   // connect to the database
   $db_connection = mysql_connect("localhost", "cs143", "");
   mysql_select_db("CS143", $db_connection);

   ////////////////////////////////////////Search Actors////////////////////////////////////////
   // get matched actors
   $pieces = explode(" ", $name);
   $query = sprintf("SELECT id, CONCAT(first, ' ', last) AS name, sex, dob
                     FROM Actor
                     WHERE LOWER(CONCAT(first, ' ', last)) LIKE LOWER('%%%s%%')",
                     mysql_real_escape_string($pieces[0]));
   for($x=1; $x < count($pieces); $x++){
     $extend = sprintf(" AND LOWER(CONCAT(first, ' ', last)) LIKE LOWER('%%%s%%')",
                      mysql_real_escape_string($pieces[$x]));
     $query = $query.$extend;
   }

   $rs = mysql_query($query, $db_connection);
   
   // print results
   print "<h2>Matching Actors:</h2>";
   print "<table border=1 cellspacing=3 cellpadding=5>";

   // get field num
   $num = mysql_num_fields($rs);
   print "<tr align=center>";

   // print field names
   for($i=1; $i < $num; $i++){
     $fname = ucfirst(mysql_field_name($rs, $i));
     print "<td>$fname</td>";
   }

   // print tuples
   while($row = mysql_fetch_row($rs)){
     // create url
     $url = "./actor.php?id=".$row[0];
     print "<tr align=center>";

     // print actor name with url
     print "<td><a href=$url>$row[1]</a></td>";

     // print the rest columns
     for($i=2; $i < $num; $i++){
       print "<td>$row[$i]</td>";
     }
   }
   print "</table>";

   ////////////////////////////////////////Search Movies////////////////////////////////////////
   // get matched movies
   $pieces = explode(" ", $name);
   $query = sprintf("SELECT id, title, year, company AS Producer
                     FROM Movie
                     WHERE LOWER(title) LIKE LOWER('%%%s%%')",
                     mysql_real_escape_string($pieces[0]));

   for($x=1; $x < count($pieces); $x++){
     $extend = sprintf(" AND LOWER(title) LIKE LOWER('%%%s%%')",
                      mysql_real_escape_string($pieces[$x]));
     $query = $query.$extend;
   }

   $rs = mysql_query($query, $db_connection);

   // print results
   print "<h2>Matching Movies:</h2>";
   print "<table border=1 cellspacing=3 cellpadding=5>";

   // get field num
   $num = mysql_num_fields($rs);
   print "<tr align=center>";

   // print field names
   for($i=1; $i < $num; $i++){
     $fname = ucfirst(mysql_field_name($rs, $i));
     print "<td>$fname</td>";
   }

   // print tuples
   while($row = mysql_fetch_row($rs)){
     // create url
     $url = "./movie.php?mid=".$row[0];
     print "<tr align=center>";

     // print actor name with url
     print "<td><a href=$url>$row[1]</a></td>";

     // print the rest columns
     for($i=2; $i < $num; $i++){
       print "<td>$row[$i]</td>";
     }
   }
   print "</table>";

   mysql_close($db_connection);
}
?>
</body>
</html>
