<html>
<head>
  <title>Movie information</title>
  <base href="." target="_blank">
  <meta name="description" content="Actor informaion">
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
// define variables and set to empty values
$mid = $_GET["mid"];
if($mid) {
   // connect to the database
   $db_connection = mysql_connect("localhost", "cs143", "");
   mysql_select_db("CS143", $db_connection);

   ////////////////////////////////////////Movie Information////////////////////////////////////////
   // get the Movie information
   $query = sprintf("SELECT title, company AS Producer, rating AS MPAA_Rating, genre 
                     FROM Movie a, MovieGenre b WHERE a.id=b.mid AND a.id='%d';",
                    mysql_real_escape_string($mid));
   $rs = mysql_query($query, $db_connection);

   // print Movie information 
   print "<h2>Movie Information:</h2>";
   $num = mysql_num_fields($rs);
   $row = mysql_fetch_row($rs);
   for($x=0; $x < $num; $x++){
        $fname = ucfirst(mysql_field_name($rs, $x));
        print "<p>$fname: $row[$x]</p>";
   }
   $query = sprintf("SELECT CONCAT(first, ' ', last) FROM Director
                     WHERE id in (SELECT did FROM MovieDirector WHERE mid='%d');",
                     mysql_real_escape_string($mid));
   $rs = mysql_query($query, $db_connection);
   $row = mysql_fetch_row($rs);
   print "<p>Director: $row[0]</p>";
  
   ////////////////////////////////////////List of Actors////////////////////////////////////////
   // get Actors information
   $aquery = sprintf("SELECT a.id, CONCAT(a.first, ' ', a.last) AS name, b.role AS role 
                     FROM Actor a, MovieActor b
                     WHERE a.id = b.aid and b.mid = '%d';",
                     mysql_real_escape_string($mid),
                     mysql_real_escape_string($mid));
   $ars = mysql_query($aquery, $db_connection);

   // print actors information
   print "<h2>Actors in the Movie:</h2>";
   print "<table border=1 cellspacing=3 cellpadding=5>";
   
   // get field num
   $anum = mysql_num_fields($ars);
   print "<tr align=center>";
   
   // print field names
   for($i=1; $i < $anum; $i++){
     $fname = ucfirst(mysql_field_name($ars, $i));
     print "<td>$fname</td>";
   }

   // print tuples
   while($row = mysql_fetch_row($ars)){
     // create url
     $url = "./actor.php?id=".$row[0];
     print "<tr align=center>";

     // print actor name with url
     print "<td><a href=$url>$row[1]</a></td>";

     // print the role
     for($i=2; $i < $anum; $i++){
       print "<td>$row[$i]</td>";
     }
   }
   print "</table>";

   ////////////////////////////////////////Score and Comments////////////////////////////////////////
   // get Scores
   $squery = sprintf("SELECT AVG(rating) FROM Review WHERE mid='%d';",
                     mysql_real_escape_string($mid));
   $srs = mysql_query($squery, $db_connection);
   
   // print Score
   $as = mysql_fetch_row($srs); 
   print "<h2>Average Score:</h2>";
   print "<p>$as[0] / 5.0</p>";		   
  
   // get comments
   $cquery = sprintf("SELECT name, rating, comment FROM Review WHERE mid='%d';",
                     mysql_real_escape_string($mid));
   $crs = mysql_query($cquery, $db_connection);
   // print comments
   print "<h2>Comments:</h2>";
   print "<p><a href='./I3.php?mid=$mid'>Add a new comment</a></p>";
   $cnum = mysql_num_fields($crs);
   while($row = mysql_fetch_row($crs)){
     for($x=0; $x < $num; $x++){
        $fname = ucfirst(mysql_field_name($crs, $x));
        print "<p>$fname: $row[$x]</p>";
     }
     print "-------------------------------------------------------------------";
   }  

   mysql_close($db_connection);
}
?>
</body>
</html>
