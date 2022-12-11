<?php
session_start();
$str = file_get_contents('creds.json'); // db username and pssowrd stored in seperate file for security, I have chosen JSON as ini.php is outside the htdocs folder
$creds = json_decode($str, true);
$username = $creds["user"];
$password = $creds["password"];
$message = "";
if (!isset($_SESSION['loggedin'])) {
    header("location:jobify.php");
} else {
    echo "<script>
            function scrollWin() {
                window.scrollTo(0, 500);
            }
        </script>
        ";
}
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
    <link rel="stylesheet" href="css/home_success.css" />
    <link rel="stylesheet" href="css/job_cards.css" />

    <!-- adding bootstrap cdn only to use rows and columns for page grid styling and cross platform compatibility -->
    <!-- main css in external stylesheet named index.css -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous" />
</head>

<body>
    <center>
        <header class="header">
            <!-- <img id="header-image" class="img-fluid" src="images/header.jpg" alt="" /> -->
            <h1><b>jobify</b></h1>
            <p><b>a one stop shop job portal</b></p>
            <a href="#nav">
                <!-- <div class="scroll"></div> -->
            </a>
        </header>
    </center>
    <!-- <br /> -->

    <?php
    include 'nav.php';
    if (isset($_POST['applyJob'])) {
        include 'applyJob.php';
    }
    ?>
    <br>
    <main>
        <div class="welcome-message">
            <h2> Welcome
                <?php
                echo  $_SESSION['name'];
                ?>
            </h2>
        </div>
        <div id="container" class="logged-in">
            <center>
                <form name="searchJobForm" method="post" action="home_success.php" align="center">
                    <h4 align="center"><b>Find your next job</b></h4>
                    <br><br>
                    <div class="row">
                        <div class="col-4">
                            <label>
                                <b>
                                    Keyword:
                                </b>
                            </label>
                            <input placeholder="Example - Doctor" type="text" maxlength="32" name="job-name">
                        </div>
                        <div class="col-4">
                            <label>
                                <b>
                                    Location:
                                </b>
                            </label>
                            <select type="select" name="job-location">
                                <option value="0" selected>--Select--</option>
                                <option value="Carlow">Carlow</option>
                                <option value="Cork">Cork</option>
                                <option value="Dublin">Dublin</option>
                                <option value="Galway">Galway</option>
                                <option value="Kildare">Kildare</option>
                                <option value="Limerick">Limerick</option>
                            </select>
                        </div>
                        <div class="col-4">
                            <label>
                                <b>
                                    Job Type:
                                </b>
                            </label>
                            <select type="select" name="job-type">
                                <option value="0" selected>--Select--</option>
                                <option value="1">Full-Time</option>
                                <option value="2">Part-Time</option>
                                <option value="3">Internship</option>
                            </select>
                        </div>
                    </div>
                    <br><br>
                    <input class="btn btn-primary" type="submit" name="jobSearch" value="Search">&nbsp;&nbsp;
                    <button class="btn btn-secondary" type="reset"><a id="reset" href="">Reset</a></button>
                    <br><br><br><br>
                </form>
            </center>
            <!-- Job Board -->
            <div class="job-board-container">
                <div class="job-board row justify-content-center">
                    <?php include "job_cards.php"; ?>
                </div>
            </div>
            <!-- Job Board ends -->
            <center>
                <div class="employer-redirect">
                    <h3>Are you an employer?</h3>
                    <h4><a href="register.php?role=employer">Click here to post a free ad now!</a></h4>
                </div>
                <br>
                <button class="btn button" type="submit"><a href="jobify.php">Back to Home</a></button>
            </center>
        </div>
    </main>
    <br />
    <hr />
    <?php
    include "footer.php";
    ?>
</body>

</html>