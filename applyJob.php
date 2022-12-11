<?php
$str = file_get_contents('creds.json'); // db username and pssowrd stored in seperate file for security, I have chosen JSON as ini.php is outside the htdocs folder
$creds = json_decode($str, true);
$username = $creds["user"];
$password = $creds["password"];

$jobID = $_POST['jobId'];
$userID = $_SESSION['user_id'];
$con = new PDO('mysql:host=localhost;dbname=project', $username, $password);
$applyJob = $con->prepare("INSERT INTO user_job_application VALUES (id, $userID, $jobID)");
$applyJob->setFetchMode(PDO::FETCH_OBJ);
if ($applyJob->execute()) {
    $message = '<div class="alert alert-success" role="alert">Successfully applied for job! Your applications will be visible in the "My Applications" Tab.</div>';
    echo "<p>" . $message . "</p>";
} else {
    $message = '<div class="alert alert-danger" role="alert">Somwthing went wrong!</div>';
    echo "<p>" . $message . "</p>";
}
