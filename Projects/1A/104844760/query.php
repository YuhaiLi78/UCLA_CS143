<html>
<head>
<?php $title = "Project 1A" ?>
<title><?php print "$title"; ?></title>
</head>

<body bgcolor=white>
<h1><?php print "$title"; ?></h1>

<?php
print "Enter the SQL query";
?>

<FORM METHOD="GET" ACTION="./query.php">
<TEXTAREA NAME="query" ROWS=5 COLS=30>
</TEXTAREA>
<br>
<INPUT TYPE='submit' VALUE='submit'>
</FORM>

<?php
$query = $_GET["query"];
if($query){
   $db_connection = mysql_connect("localhost", "cs143", "");
   mysql_select_db("CS143", $db_connection);
   $rs = mysql_query($query, $db_connection);
   print "<table border=1 cellspacing=1 cellpadding=2>";
   $num = mysql_num_fields($rs);
   print "<tr align=center>";
   for($i=0; $i < $num; $i++){
	$name=mysql_field_name($rs, $i);
	print "<td>$name</td>";
   }
   while($row = mysql_fetch_row($rs)){
       print "<tr align=center>";
       foreach($row as $value){
           print "<td>$value</td>";
       }
   }
   print "</table>";
   $affected = mysql_affected_rows($db_connection);
   print "Total affected rows: $affected<br />";
   mysql_close($db_connection);
}
?>
</body>
</html>
