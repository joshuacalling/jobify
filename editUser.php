<?php
session_start();
$str = file_get_contents('creds.json'); // db username and pssowrd stored in seperate file for security, I have chosen JSON as ini.php is outside the htdocs folder
$creds = json_decode($str, true);
$username = $creds["user"];
$password = $creds["password"];
$userId = $_SESSION['user_id']; // $_SESSION['user_id']
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8" />
    <meta name="Jobify" content="Find Jobs near you" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="author" content="Joshua Abhijeet Pereira" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Jobify - Contact</title>
    <link rel="stylesheet" href="css/index.css" />
    <link rel="stylesheet" href="css/about.css" />
    <!-- adding bootstrap cdn only to use rows and columns for page grid styling and cross platform compatibility -->
    <!-- main css in external stylesheet named index.css -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous" />
</head>

<body>
    <?php
    $con = new PDO('mysql:host=localhost;dbname=project', $username, $password);
    $userDetailQuery = $con->prepare("SELECT * FROM user WHERE id = $userId");
    $userDetailQuery->setFetchMode(PDO::FETCH_OBJ);
    $userDetailQuery->execute();
    if ($userDetailQuery->rowCount()  > 0) {
    ?>
        <center>
            <header class="header">
                <img id="header-image" class="img-fluid" src="images/header.jpg" alt="" />
                <h1><b>jobify</b></h1>
                <p><b>a one stop shop job portal</b></p>
            </header>
        </center>
        <br />
        <main>
            <hr>
            <div class=" row container">
                <h1>Edit your profile details</h1>
            </div>
            <?php
            if (isset($_POST['modifyUser'])) {
                $con = new PDO('mysql:host=localhost;dbname=project', $username, $password);
                $fullName = $_POST['form-full-name'];
                $username = $_POST['form-username'];
                $pass = $_POST['form-password'];
                $passRetype = $_POST['form-password-retype'];
                $email = $_POST['form-email'];
                $createFlag = true;
                if ((strlen($fullName) == 0) || (strlen($username) == 0) || (strlen($pass) == 0) || (strlen($passRetype) == 0) || strlen($email) == 0) {
                    $message =
                        '<div class="alert alert-danger" role="alert">All fields must be filled.</div>';
                    echo "<p>" . $message . "</p>";
                    $createFlag = false;
                }
                if ($pass != $passRetype) {
                    $message =
                        '<div class="alert alert-danger" role="alert">Passwords do not match.</div>';
                    echo "<p>" . $message . "</p>";
                    $createFlag = false;
                }
                if ($createFlag) {
                    $modUser = $con->prepare("UPDATE user SET name ='$fullName', email ='$email', username ='$username', password = md5('$pass') WHERE id = $userId");
                    $modUser->setFetchMode(PDO::FETCH_OBJ);
                    if ($modUser->execute()) {
                        $message = '<div class="alert alert-success" role="alert">User was updated successfully</div>';
                        echo "<p>" . $message . "</p>";
                    } else {
                        $message =
                            '<div class="alert alert-warning" role="alert">Something went wrong, please try again.</div>';;
                        echo "<p>" . $message . "</p>";
                    }
                }
            }
            ?>
            <br>
            <div class="row">
                <div class="col">
                    <form class="form-control" name="registerForm" method="post" action="editUser.php" align="center">
                        <h4 align="center">Please enter all fields before saving</h4>
                        <br><br><br><br>
                        <?php
                        while ($row = $userDetailQuery->fetch()) {
                        ?>
                            Full Name<br>
                            <input placeholder="<?php echo ($row->name) ?>" type="text" maxlength="32" name="form-full-name">
                            <br>
                            Username<br>
                            <input placeholder="<?php echo ($row->username) ?>" type="text" maxlength="32" name="form-username">
                            <br>
                            Email<br>
                            <input placeholder="<?php echo ($row->email) ?>" type="email" maxlength="48" name="form-email">
                            <br>
                            New Password<br>
                            <input type="password" name="form-password">
                            <br><br>
                            Re-enter Password<br>
                            <input type="password" name="form-password-retype">
                            <br><br>
                    <?php
                        }
                    }
                    ?>
                    <input class="btn btn-primary" type="submit" name="modifyUser" value="Update">
                    <input class="btn btn-secondary" type="reset">
                    <br><br><br><br>
                    <button class="btn" type="submit"><a href="jobify.php">Back to Login</a></button>
                    </form>
                </div>
            </div>
            </div>
            <br>
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