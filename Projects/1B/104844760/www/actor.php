<html>
<head>
  <title>Actor information</title>
  <base href="." target="_blank">
  <meta name="description" content="Actor informaion">
  <meta name="author" content="Yuhai Li">
  <style>.error {color: #FF0000;}</style>
  <meta name="viewpoint" content="width=device-width, initial-scale=1.0">
</head>  
<body>
<p><a href="./home.php">Home</a></p>
<form method="GET" action="./search.php">
  Search:<input type="text" name="name">
  <br></br>
</form>

<?php
// define variables and set to empty values
$id = $_GET["id"];
if($id) {
   // connect to the database
   $db_connection = mysql_connect("localhost", "cs143", "");
   mysql_select_db("CS143", $db_connection);

   // get the Actor information
   $query = sprintf("SELECT CONCAT(first, ' ', last) AS name, sex, dob AS Date_of_Birth 
                    FROM Actor WHERE id='%d';",
                    mysql_real_escape_string($id));
   $rs = mysql_query($query, $db_connection);

   // print Actor information 
   print "<h2>Actor Information:</h2>";
   $num = mysql_num_fields($rs);
   $row = mysql_fetch_row($rs);
   for($x=0; $x < $num; $x++){
        $fname = ucfirst(mysql_field_name($rs, $x));
        print "<p>$fname: $row[$x]</p>";
   }
  
   // get movie information
   $mquery = sprintf("SELECT id, title, year
                     FROM Movie
                     WHERE id in (
                     SELECT mid FROM MovieActor WHERE aid='%d');",
                     mysql_real_escape_string($id));
   $mrs = mysql_query($mquery, $db_connection);

   // print movie information
   print "<h2>Actor's Movies:</h2>";
   print "<table border=1 cellspacing=3 cellpadding=5>";
   
   // get field num
   $mnum = mysql_num_fields($mrs);
   print "<tr align=center>";
   
   // print field names
   for($i=1; $i < $mnum; $i++){
     $fname = ucfirst(mysql_field_name($mrs, $i));
     print "<td>$fname</td>";
   }

   // print Role colunm name
   print "<td>Role</td>";

   // print tuples
   while($row = mysql_fetch_row($mrs)){
     // create url
     $url = "./movie.php?mid=".$row[0];
     print "<tr align=center>";

     // print title with url
     print "<td><a href=$url>$row[1]</a></td>";

     // print the rest columns
     for($i=2; $i < $mnum; $i++){
       print "<td>$row[$i]</td>";
     }

     // set query
     $rquery = sprintf("SELECT role FROM MovieActor WHERE mid='%d' AND aid='%d';",
                        mysql_real_escape_string($row[0]),
                        mysql_real_escape_string($id));
     
     // return the role of actor in the movie
     $rrs = mysql_query($rquery, $db_connection);
     $role = mysql_fetch_row($rrs);

     // print role
     print "<td>$role[0]</td>";
   }
   print "</table>";
   mysql_close($db_connection);
}
?>
</body>
</html>
