<html>
<head>
  <title>Add actor/director to movie relation</title>
  <meta name="description" content="Add actor/director to movie relation">
  <meta name="author" content="Yuhai Li">
  <meta name="viewpoint" content="width=device-width, initial-scale=1.0">
  <style>.error {color: #FF0000;}</style>
</head>  
<body>

<?php
// define variables and set to empty values
$ad = $mid = $id = $role = "";
$sucMeg = "";
if($_SERVER["REQUEST_METHOD"] == "GET") {
  // get inputs
  $ad = $_GET["ad"];
  $mid = $_GET["mid"];
  $id = $_GET["id"];
  $role = $_GET["role"];

  if($mid && $id){
    // invalid input
    // connect to the database
    $db_connection = mysql_connect("localhost", "cs143", "");
    mysql_select_db("CS143", $db_connection);

    // set query
    if ($ad == "Actor"){
      $query = sprintf("INSERT INTO MovieActor VALUES('%d', '%d', '%s');",
                       mysql_real_escape_string($mid),
                       mysql_real_escape_string($id),
                       mysql_real_escape_string($role));
    }
    else {
       $query = sprintf("INSERT INTO MovieDirector VALUES('%d', '%d');",
          mysql_real_escape_string($mid),
          mysql_real_escape_string($id));
    }
    $rs = mysql_query($query,$db_connection);
    if(mysql_affected_rows($db_connection) != -1){
       $sucMeg = "The ".$ad." is inserted successfully.";
    }else{
      $sucMeg = "The insertion is rejected.";
    }
    mysql_close($db_connection);
  }
}
?>
<p><a href="./home.php">Home</a></p>
<h2>Add Actor/Director to Movie Relation</h2>
<p><span class="error">* required field.</span></p>
<form method="get" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
  Actor/Director: <select name="ad" required><option>Actor</option><option>Director</option></select>
  <span class="error">*</span>
  <br></br>
  Movie ID: <input type="text" name="mid" value="<?php echo $mid;?>">
  <span class="error">*</span>
  <br></br>
  Actor/Director ID: <input type="text" name="id" value="<?php echo $id;?>">
  <span class="error">*</span>
  <br></br>
  Role(applicable to Actor only): <input type="text" name="role" value="<?php echo $role;?>">
  <span class="error">*</span>
  <br></br>
  <input type="submit" name="submit" value="Submit">
  <br></br>
  <p><span class="error"><?php echo $sucMeg;?></span></p>
  <br></br>
</form>
</body>
</html>
