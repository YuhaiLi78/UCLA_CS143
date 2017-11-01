<html>
<head>
  <title>Add Comments</title>
  <meta name="description" content="Add Comments">
  <meta name="author" content="Yuhai Li">
  <meta name="viewpoint" content="width=device-width, initial-scale=1.0">
  <style>.error {color: #FF0000;}</style>
</head>  
<body>

<?php
// define variables and set to empty values
$name = $mid = $rating = $comment;
$sucMeg = "";

if($_SERVER["REQUEST_METHOD"] == "GET") {
  $name = $_GET["name"];
  $mid = $_GET["mid"];
  $rating = $_GET["rating"];
  $comment = $_GET["comment"];
 
  if(!empty($name) && !empty($mid) && !empty($rating) && !empty($comment)){
    // invalid input
    // connect to the database
    $db_connection = mysql_connect("localhost", "cs143", "");
    mysql_select_db("CS143", $db_connection);

    // set query
    $query = sprintf("INSERT INTO Review VALUES('%s', CURRENT_TIMESTAMP(), '%d', '%d', '%s');",
                      mysql_real_escape_string($name),
                      mysql_real_escape_string($mid),
                      mysql_real_escape_string($rating),
                      mysql_real_escape_string($comment));

    $rs = mysql_query($query,$db_connection);

    if(mysql_affected_rows($db_connection) != -1){
      $sucMeg = "The Movie is inserted successfully.";
    }else{
      $sucMeg = "The insertion is rejected.";
    }
    mysql_close($db_connection);
  }
}
?>
<p><a href="./home.php">Home</a></p>
<h2>Add Comment</h2>
<p><span class="error">* required field.</span></p>
<form method="GET" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
  Review Name: <input type="text" name="name" value="<?php echo $name;?>">
  <span class="error">*</span>
  <br></br>
  Movie ID: <input type="text" name="mid" value="<?php echo $mid;?>">
  <span class="error">*</span>
  <br></br>
  Raview Rating:
  <select name="rating">
    <option disabled selected value> -- select a rating -- </option>
    <?php 
       for($x=0; $x <= 5; $x++){
         echo "<option>$x</option>";
      }
    ?>
  </select>
  <span class="error">*</span>
  <br></br>
  Comment:
  <br></br>
  <TEXTAREA name="comment" rows=10 cols=60><?php echo $comment;?></TEXTAREA>
  <span class="error">*</span>
  <br></br>
  <input type="submit" name="submit" value="Submit">
  <br></br>
  <p><span class="error"><?php echo $sucMeg;?></span></p>
  <br></br>
</form>
</body>
</html>
