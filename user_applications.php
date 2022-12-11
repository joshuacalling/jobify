<?php
session_start();
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
    <title>My Applications</title>
    <!-- adding bootstrap cdn only to use rows and columns for page grid styling and cross platform compatibility -->
    <!-- main css in external stylesheet named index.css -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous" />
    <link rel="stylesheet" href="css/index.css" />
    <link rel="stylesheet" href="css/my_application.css" />

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
        <?php
        include "nav.php";
        ?>
        <br />
        <div class="welcome-message">
            <h2>
                <?php
                echo  $_SESSION['name'];
                ?>'s Applications
            </h2>
        </div>
        <?php
        if (isset($_POST['withdraw-button'])) {
            $withdrawId = $_POST['withdraw-button'];
            $con = new PDO('mysql:host=localhost;dbname=project', $username, $password);
            $deleteApp = $con->prepare("DELETE FROM user_job_application WHERE id = $withdrawId");
            $deleteApp->setFetchMode(PDO::FETCH_OBJ);
            if ($deleteApp->execute()) {
                $message = '<div class="alert alert-success" role="alert">Application withdrawn successfully.</div>';;
                echo "<p>" . $message . "</p>";
            } else {
                $message = '<div class="alert alert-warning" role="alert">Something went wront, please try again.</div>';;
                echo "<p>" . $message . "</p>";
            }
        }
        ?>
        <br>
        <main>
            <div class="container">
                <div class="row">
                    <table class="table">
                        <thead class="thead-light">
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Employer</th>
                                <th scope="col">Job Title</th>
                                <th scope="col">Job Type</th>
                                <th scope="col">Location</th>
                                <th scope="col">Action</th>
                            </tr>
                        </thead>
                        <form method="post" action="user_applications.php">
                            <tbody>
                                <?php
                                $con = new PDO('mysql:host=localhost;dbname=project', $username, $password);
                                $userId = $_SESSION['user_id'];
                                $appList = $con->prepare(" SELECT app.id AS application_id, u.name AS full_name,   j.name AS job_name,   jt.type AS job_type,   l.county AS location,   e.name AS emp_name FROM   user_job_application as app   JOIN user u ON user_id = u.id   JOIN job j ON job_id = j.id  JOIN job_type jt ON job_type_id = jt.id  JOIN location l ON location_id = l.id  JOIN employer e ON employer_id = e.id WHERE  app.user_id = $userId");
                                $appList->setFetchMode(PDO::FETCH_OBJ);
                                $rowCounter = 1;
                                if ($appList->execute() && $appList->rowCount()  > 0) {
                                    while ($row = $appList->fetch()) {
                                ?>
                                        <tr>
                                            <th scope="row"><?= $rowCounter ?></th>
                                            <td><?= $row->emp_name ?></td>
                                            <td><?= $row->job_name ?></td>
                                            <td><?= $row->job_type ?></td>
                                            <td><?= $row->location ?></td>
                                            <td><button class="btn btn-warning" value="<?= $row->application_id ?>" type="submit" name="withdraw-button">Withdraw</button></td>
                                        </tr>
                                    <?php
                                        $rowCounter++;
                                    }
                                } else {
                                    ?>
                                    <tr>
                                        <th scope="row"><?= $rowCounter ?></th>
                                        <td>N/A</td>
                                        <td>N/A</td>
                                        <td>N/A</td>
                                        <td>N/A</td>
                                        <td>N/A</td>
                                    </tr>
                                <?php
                                }
                                ?>
                            </tbody>
                        </form>
                    </table>
                </div>
            </div>
        </main>
    </center>
</body>
<?php
include "footer.php";
?>

</html>