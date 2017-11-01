<html>
<head>
  <title>Add actor/director information</title>
  <meta name="description" content="Add actor/director informaion">
  <meta name="author" content="Yuhai Li">
  <meta name="viewpoint" content="width=device-width, initial-scale=1.0">
  <style>.error {color: #FF0000;}</style>
</head>  
<body>

<?php
// define variables and set to empty values
$lnErr = $fnErr = "";
$ad = $ln = $fn = $sex = $dob = $dod = "";
$sucMeg = "";
if($_SERVER["REQUEST_METHOD"] == "GET") {
  if (empty($_GET["ln"])){
    // if no input for last name
    $lnErr = "Last Name is required";
  }
  else{
    $ln = $_GET["ln"];
  }
  if (empty($_GET["fn"])){
    // if no input for first name
    $fnErr = "First Name required";
  }
  else{
    $fn = $_GET["fn"];
  }
 
  if($ln && $fn){
    // invalid input
    // connect to the database
    $db_connection = mysql_connect("localhost", "cs143", "");
    mysql_select_db("CS143", $db_connection);

    // get and set the inputs
    $ad = $_GET["ad"];
    $sex = $_GET["sex"];
    $dob = $_GET["by"]."-".$_GET["bm"]."-".$_GET["bd"];
    if ($_GET["dy"] && $_GET["dm"] && $_GET["dd"]){
      $dod = $_GET["dy"]."-".$_GET["dm"]."-".$_GET["dd"];
    }
    else{
      $dod = "NULL";
    }
    
    // get id and update MaxPersonID
    $rs = mysql_query("SELECT * FROM MaxPersonID", $db_connection);
    $row = mysql_fetch_row($rs);
    $id = $row[0] + 1;
    
    // set query
    if ($ad == "Actor"){
      $query = sprintf("INSERT INTO Actor VALUES('%d', '%s', '%s', '%s', '%s', '%s');",
                       mysql_real_escape_string($id),
                       mysql_real_escape_string($ln),
                       mysql_real_escape_string($fn),
                       mysql_real_escape_string($sex),
                       mysql_real_escape_string($dob),
                       mysql_real_escape_string($dod));
    }
    else {
       $query = sprintf("INSERT INTO Director VALUES('%d', '%s', '%s', '%s', '%s');",
          mysql_real_escape_string($id),
          mysql_real_escape_string($ln),
          mysql_real_escape_string($fn),
          mysql_real_escape_string($dob),
          mysql_real_escape_string($dod));
    }
    $rs = mysql_query($query,$db_connection);
    if(mysql_affected_rows($db_connection) != -1){
      $rs = mysql_query("UPDATE MaxPersonID SET id=id+1;", $db_connection);
      $sucMeg = "The ".$ad."(ID:".$id.") is inserted successfully.";
    }else{
      $sucMeg = "The insertion failed";
    }
    mysql_close($db_connection);
  }
}
?>
<p><a href="./home.php">Home</a></p>
<h2>Add actor/director information</h2>
<p><span class="error">* required field.</span></p>
<form method="get" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
  Actor/Director: <select name="ad" required><option>Actor</option><option>Director</option></select>
  <span class="error">*</span>
  <br></br>
  Last Name: <input type="text" name="ln" value="<?php echo $ln;?>">
  <span class="error">* <?php echo $lnErr;?></span>
  <br></br>
  First Name: <input type="text" name="fn" value="<?php echo $fn;?>">
  <span class="error">* <?php echo $fnErr;?></span>
  <br></br>
  Sex: <select name="sex" required><option>Male</option><option>Female</option></select>
  <span class="error">*</span>
  <br></br>
  Date of Birth (mm-dd-yyyy):
  <select name="bm" required>
    <option disabled selected value> -- select a month -- </option>
    <?php
       for ($x=1; $x <= 12; $x++){
         echo "<option>$x</option>";
       }
    ?>
  </select>
  <select name="bd" required>
    <option disabled selected value> -- select a day -- </option>
    <?php
       for ($x=1; $x <= 31; $x++){
         echo "<option>$x</option>";
       }
    ?>
  </select>
  <select name="by" required>
    <option disabled selected value> -- select a year -- </option>
    <?php
       for ($x=1900; $x <= 2017; $x++){
         echo "<option>$x</option>";
       }
    ?>
  </select>
  <span class="error">*</span>
  <br></br>
  Date of Death (mm-dd-yyyy): 
  <select name="dm">
    <option disabled selected value> -- select a month -- </option>
    <?php
       for ($x=1; $x <= 12; $x++){
         echo "<option>$x</option>";
       }
    ?>
  </select>
  <select name="dd">
    <option disabled selected value> -- select a day -- </option>
    <?php
       for ($x=1; $x <= 31; $x++){
         echo "<option>$x</option>";
       }
    ?>
  </select>
  <select name="dy">
    <option disabled selected value> -- select a year -- </option>
    <?php
       for ($x=1900; $x <= 2017; $x++){
         echo "<option>$x</option>";
       }
    ?>
  </select>
  <br></br>
  <input type="submit" name="submit" value="Submit">
  <br></br>
  <p><span class="error"><?php echo $sucMeg;?></span></p>
  <br></br>
</form>
</body>
</html>
