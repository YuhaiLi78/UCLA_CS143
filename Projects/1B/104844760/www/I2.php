<html>
<head>
  <title>Add movie information</title>
  <meta name="description" content="Add movie informaion">
  <meta name="author" content="Yuhai Li">
  <meta name="viewpoint" content="width=device-width, initial-scale=1.0">
  <style>.error {color: #FF0000;}</style>
</head>  
<body>

<?php
// define variables and set to empty values
$titErr = $q1Err = $q2Err = $q3Err = "";
$title = $year = $rating = $company = "";
$genre = $imda = $rot = "";
$sucMeg = "";
if($_SERVER["REQUEST_METHOD"] == "GET") {
  if (empty($_GET["title"])){
    // if no input for title
    $titErr = "Title is required";
  }
  else{
    $title = $_GET["title"];
  }
 
  if($title){
    // invalid input
    // connect to the database
    $db_connection = mysql_connect("localhost", "cs143", "");
    mysql_select_db("CS143", $db_connection);

    // get and set the inputs
    $year = $_GET["year"];
    $rating = $_GET["rating"];
    $company = $_GET["company"];
    $imdb = $_GET["imdb"];
    $rot = $_GET["rot"];
    $g = $_GET["genre"];
    $genre="";
    foreach($g as $e){
      $genre = $genre."/".$e;
    }
    // get id and update MaxMovieID
    $rs = mysql_query("SELECT * FROM MaxMovieID", $db_connection);
    $row = mysql_fetch_row($rs);
    $id = $row[0] + 1;
    
    // set query
    $query = sprintf("INSERT INTO Movie VALUES('%d', '%s', '%d', '%s', '%s');",
                      mysql_real_escape_string($id),
                      mysql_real_escape_string($title),
                      mysql_real_escape_string($year),
                      mysql_real_escape_string($rating),
                      mysql_real_escape_string($company));

    $rs = mysql_query($query,$db_connection);
    $q1Err = mysql_affected_rows($db_connection);

    if($imdb || $rot){
      // if user entered imdb or rot score
      $query = sprintf("INSERT INTO MovieRating VALUES('%d', '%d', '%d');",
                        mysql_real_escape_string($id),
                        mysql_real_escape_string($imdb),
                        mysql_real_escape_string($rot));
      $rs = mysql_query($query,$db_connection);
      $q2Err = mysql_affected_rows($db_connection);
    }

    if($genre){
      // if user chose genre
      $query = sprintf("INSERT INTO MovieGenre VALUES('%d', '%s');",
                       mysql_real_escape_string($id),
                       mysql_real_escape_string($genre));
      $rs = mysql_query($query,$db_connection);
      $q3Err = mysql_affected_rows($db_connection);
    }

    if($q1Err != -1 && $q2Err != -1 && $q3Err != -1){
      $rs = mysql_query("UPDATE MaxMovieID SET id=id+1;", $db_connection);
      $sucMeg = "The Movie(ID:".$id.") is inserted successfully.";
    }else{
      $sucMeg = "The insertion failed.";
    }
    mysql_close($db_connection);
  }
}
?>
<p><a href="./home.php">Home</a></p>
<h2>Add Movie information</h2>
<p><span class="error">* required field.</span></p>
<form method="GET" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
  Title: <input type="text" name="title" value="<?php echo $title;?>">
  <span class="error">* <?php echo $titErr;?></span>
  <br></br>
  Year: <input type="text" name="year" value="<?php echo $year;?>">
  <br></br>
  Rating: 
  <select name="rating">
    <option disabled selected value> -- select a rating -- </option>
    <option>PG-13</option>
    <option>R</option>
    <option>PG</option>
    <option>NC-17</option>
    <option>surrendere</option>
    <option>G</option>
  </select>
  <br></br>
  IMDb Rating:
  <select name="imdb">
    <option disabled selected value> -- select a rating -- </option>
    <?php 
       for($x=0; $x <= 100; $x++){
         echo "<option>$x</option>";
      }
    ?>
  </select>
  <br></br>
  Rotten Tomatoes Rating:
  <select name="rot">
    <option disabled selected value> -- select a rating -- </option>
    <?php
       for($x=0; $x <= 100; $x++){
         echo "<option>$x</option>";
      }
    ?>
  </select>
  <br></br>
  Genre:
  <select name="genre[]" MULTIPLE>
    <option disabled selected value> -- select a genre -- </option>
    <option>Drama</option>
    <option>Comedy</option>
    <option>Romance</option>
    <option>Crime</option>
    <option>Horror</option>
    <option>Mystery</option>
    <option>Thriller</option>
    <option>Action</option>
    <option>Adventure</option>
    <option>Fantasy</option>
    <option>Documentary</option>
    <option>Family</option>
    <option>Sci-Fi</option>
    <option>Animation</option>
    <option>Musical</option>
    <option>War</option>
    <option>Western</option>
    <option>Adult</option>
    <option>Short</option>
  </select>
  <br></br>
  Company: <input type="text" name="company" value="<?php echo $company;?>">
  <br></br>
  <input type="submit" name="submit" value="Submit">
  <br></br>
  <p><span class="error"><?php echo $sucMeg;?></span></p>
  <br></br>
</form>
</body>
</html>
