<?php
session_start();
session_destroy();
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
    <title>Register</title>
    <!-- adding bootstrap cdn only to use rows and columns for page grid styling and cross platform compatibility -->
    <!-- main css in external stylesheet named index.css -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous" />
    <link rel="stylesheet" href="css/index.css" />
    <link rel="stylesheet" href="css/register.css" />

</head>

<body>
    <center>
        <header class="header">
            <!-- <img id="header-image" class="img-fluid" src="images/header.jpg" alt="" /> -->
            <h1><b>jobify</b></h1>
            <p><b>a one stop shop job portal</b></p>
            <!-- <div class="scroll"></div> -->
            <hr>
        </header>
        <br />
        <main>
            <?php
            $role = $_SESSION['role'] = $_GET['role'];
            if ($role == 'user') {
            ?>
                <div id="user-view" class="row container">
                    <row>
                        <?php
                        if (isset($_POST['createUser'])) {
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
                                $newUser = $con->prepare("INSERT INTO project.user VALUES (id, '$fullName', '$email', '$username', md5('$pass'))");
                                $newUser->setFetchMode(PDO::FETCH_OBJ);
                                if ($newUser->execute()) {
                                    $message = '<div class="alert alert-success" role="alert">User was added successfully</div>';
                                    echo "<p>" . $message . "</p>";
                                } else {
                                    $message =
                                        '<div class="alert alert-warning" role="alert">Something went wrong, please try again.</div>';;
                                    echo "<p>" . $message . "</p>";
                                }
                            }
                        }
                        ?>
                    </row>
                    <div class="col-6">
                        <h1>&nbsp;</h1>
                        <img src="images/register-user.jpg" class="img-fluid" alt="Picture of various professions">
                    </div>
                    <div class="col-6">
                        <h1>User Registration</h1>
                        <form class="form-control" name="registerForm" method="post" action="register.php?role=user" align="center">
                            <h4 align="center">Enter Your Details to Register</h4>
                            <br><br><br><br>
                            Full Name<br>
                            <input type="text" maxlength="32" name="form-full-name">
                            <br>
                            Username<br>
                            <input type="text" maxlength="32" name="form-username">
                            <br>
                            Email<br>
                            <input type="email" maxlength="48" name="form-email">
                            <br>
                            Password<br>
                            <input type="password" name="form-password">
                            <br><br>
                            Re-enter Password<br>
                            <input type="password" name="form-password-retype">
                            <br><br>
                            <input class="btn btn-primary" type="submit" name="createUser" value="Create">
                            <input class="btn btn-secondary" type="reset">
                            <br><br><br><br>
                            <button class="btn" type="submit"><a href="jobify.php">Back to Login</a></button>
                        </form>
                        <div class="employer-redirect">
                            <h3>Are you an employer?</h3>
                            <h4><a href="register.php?role=employer">Click here to post a free ad now!</a></h4>
                        </div>
                    </div>
                </div>

            <?php
            } else if ($role == 'employer') {
                // $_SESSION['role'] == 'employer' will be the other possible value
            ?>
                <div id="employer-view">
                    <!-- <h2>Employee View</h2> -->
                    <div id="user-view" class="row container">
                        <row>
                            <?php
                            if (isset($_POST['createJob'])) {
                                $con = new PDO('mysql:host=localhost;dbname=project', $username, $password);
                                $employerName = $_POST['form-company-name'];
                                $jobName = $_POST['form-job-name'];
                                $jobDescription = $_POST['form-job-about'];
                                $jobType_id = $_POST['form-job-type'];
                                $jobLocation_id = $_POST['form-location'];
                                $createFlag = true;
                                if ((strlen($employerName) == 0) || strlen($jobName == 0) || ($jobType_id == 0) || ($jobLocation_id == 0)) {
                                    $message =
                                        '<div class="alert alert-danger" role="alert">All fields must be filled.</div>';
                                    echo "<p>" . $message . "</p>";
                                    $createFlag = false;
                                }
                                if ($createFlag) {
                                    $newEmployer = $con->prepare("INSERT INTO employer VALUES (id, '$employerName', '$jobLocation_id')");
                                    $newEmployer->setFetchMode(PDO::FETCH_OBJ);
                                    if ($newEmployer->execute()) {
                                        $employerId = $con->lastInsertId();
                                        $newJob = $con->prepare("INSERT INTO job VALUES (id, '$jobName', '$jobDescription', '$jobType_id', '$employerId', '$jobLocation_id')");
                                        $newJob->setFetchMode(PDO::FETCH_OBJ);
                                        if ($newJob->execute()) {
                                            $message = '<div class="alert alert-success" role="alert">Job post was added successfully</div>';
                                            echo "<p>" . $message . "</p>";
                                        } else {
                                            $message =
                                                '<div class="alert alert-warning" role="alert">Something went wrong, please try again.</div>';;
                                            echo "<p>" . $message . "</p>";
                                        }
                                    } else {
                                        $message = '<div class="alert alert-warning" role="alert">Something went wrong trying to register employer, please try again.</div>';;
                                        echo "<p>" . $message . "</p>";
                                    }
                                }
                            }
                            ?>
                        </row>
                        <div class="col-6">
                            <h1>&nbsp;</h1>
                            <img src="images/register-employer.jpg" class="img-fluid" alt="Picture of various professions">
                        </div>
                        <div class="col-6">
                            <h1>Employer Registration</h1>
                            <form class="form-control" name="registerForm" method="post" action="register.php?role=employer" align="center">
                                <h4 align="center">Post a <i>new</i> Job</h4>
                                <br><br><br><br>
                                Company Name:<br>
                                <input class="form-input" type="text" maxlength="32" name="form-company-name">
                                <br>
                                Job Title:<br>
                                <input class="form-input" type="text" maxlength="32" name="form-job-name">
                                <br>
                                Job Description:<br>
                                <textarea maxlength="500" class="form-input" type="text" name="form-job-about"></textarea>
                                <br>
                                <br><br>
                                Job Type:<br>
                                <select type="select" name="form-job-type">
                                    <option value="0" selected>--Select--</option>
                                    <option value="1">Full-Time</option>
                                    <option value="2">Part-Time</option>
                                    <option value="3">Internship</option>
                                </select><br>
                                Location:<br>
                                <select type="select" name="form-location">
                                    <option value="0" selected>--Select--</option>
                                    <option value="1">Carlow</option>
                                    <option value="2">Cork</option>
                                    <option value="3">Dublin</option>
                                    <option value="4">Galway</option>
                                    <option value="5">Kildare</option>
                                    <option value="6">Limerick</option>
                                </select>
                                <br>
                                <br><br>
                                <input type="submit" name="createJob" value="Post Job">
                                <input type="reset">
                                <br><br><br><br>
                                <button class="btn" type="submit"><a href="jobify.php">Back to Login</a></button>
                            </form>
                            <div class="employer-redirect">
                                <h3>Are you a jobseeker?</h3>
                                <h4><a href="register.php?role=user">Click here to signup and find your next job!</a></h4>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- employer view ends here -->
                <hr>
                <footer>
                    &nbsp;
                </footer>
            <?php
            } else {
                echo "<center><h2>Please try again...something went wrong :(</h2></center>";
            }
            ?>



        </main>
    </center>
</body>
<?php
include "footer.php";
?>

</html>