<?php
$str = file_get_contents('creds.json'); // db username and pssowrd stored in seperate file for security, I have chosen JSON as ini.php is outside the htdocs folder
$creds = json_decode($str, true);
$username = $creds["user"];
$password = $creds["password"];
$message = '';
?>

<!DOCTYPE html>
<html>

<head>
  <meta charset="UTF-8" />
  <meta name="Jobify" content="Find Jobs near you" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="author" content="Joshua Abhijeet Pereira" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Jobify</title>
  <link rel="stylesheet" href="css/index.css" />
  <!-- adding bootstrap cdn only to use rows and columns for page grid styling and cross platform compatibility -->
  <!-- main css in external stylesheet named index.css -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous" />
</head>

<body>
  <center>
    <header class="header">
      <img id="header-image" class="img-fluid" src="images/header.jpg" alt="" />
      <h1><b>jobify</b></h1>
      <p><b>a one stop shop job portal</b></p>
      <a href="#nav">
        <div class="scroll"></div>
      </a>
    </header>
  </center>
  <br />
  <main>
    <?php
    include 'nav.php';
    ?>
    <hr />
    <!-- login view -->
    <form name="loginForm" method="post" action="jobify.php" align="center">
      <h3 align="center"><u>User Login</u></h3>
      <br>
      Username<br>
      <input type="text" name="formUserName">
      <br>
      Password<br>
      <input type="password" name="formPassword">
      <br><br>
      <input class="btn btn-primary" type="submit" name="submit" value="Submit">
      <input class="btn btn-secondary" type="reset">
    </form>
    <br>
    <?php
    try {
      if (count($_POST) > 0) {
        session_start();
        $con = new PDO('mysql:host=localhost;dbname=project', $username, $password);
        $user = $_POST['formUserName'];
        $pass = $_POST['formPassword'];
        $userlogin = $con->prepare("SELECT * FROM user WHERE user.username = '$user' AND user.password = md5('$pass') ");
        $userlogin->setFetchMode(PDO::FETCH_OBJ);
        $userlogin->execute();

        if ($userlogin->rowCount()  == 1) {
          $_SESSION['loggedin'] = true; // $_SESSION['loggedin'] = true or false would work too
          $_SESSION['username'] = $user;
          while ($row = $userlogin->fetch()) {
            $_SESSION['name'] = $row->name;
            $_SESSION['user_id'] = $row->id;
          }
          header("Location: home_success.php"); //redirect to homepage 
        } else {
          $_SESSION['loggedin'] = false;
          header("Location: jobify.php?msg=Login_Failed");
          $message = '<label>Login failed, please try again or register.</label>';
        }
      }
    } catch (PDOException $e) {
      print "Error! database.php>>>>>>>>>>: " . $e->getMessage() . "<br/>";
      die();
    }
    ?>
    <!-- login view ends -->
    <!-- main container -->
    <div id="container" class="logged-in">
      <div class="row">
        <div class="col-4">
          <center>
            <h1>BROWSE</h1>
          </center>
        </div>
        <div class="col-4">
          <center>
            <h1>APPLY</h1>
          </center>
        </div>
        <div class="col-4">
          <h1>CREATE YOUR FUTURE</h1>
        </div>
      </div>
      <div class="row">
        <div class="col-4">
          <img height="300px" width="450px" src="images/browse.jpg" alt="Picture of user browsing the web">
        </div>
        <div class="col-4">
          <img height="300px" width="450px" src="images/apply.jpg" alt="Picture of person focusing">
        </div>
        <div class="col-4">
          <img height="300px" width="450px" src="images/Success.jpg" alt="Picture of a successful person">
        </div>
      </div>
    </div>
  </main>
  <br />
  <hr />
  <footer>
    <center>
      <p>Jobify&#8482; All rights reserved. Last updated on
        <?php
        echo date("M-Y");
        ?>
      </p>
    </center>
  </footer>
</body>

</html>