<?php
$message = "";
$dir_path = "images/Logos/";
$files = scandir($dir_path);
$count = count($files);
if (isset($_POST['jobSearch'])) {
    //search all job code
    $jobKeyword = $_POST['job-name'];
    $jobKeyFilter = ucfirst(strtolower($jobKeyword));
    $location = $_POST['job-location'];
    $jobType = $_POST['job-type'];

    if ((strlen($jobKeyword) == 0) || ($location == 0) || ($jobType == 0)) {
        $message = "Please enter all search parameters.";
        echo   '<span id="userMessage" style="color: red;">' . $message . '</span>';
    } else {
        $con = new PDO('mysql:host=localhost;dbname=project', $username, $password);
        $jobQuery = $con->prepare(
            " SELECT
                j.id as job_id,
                j.name AS job_name,
                j.description AS job_about,
                jt.type AS job_type,
                l.county AS county,
                e.name AS emp_name
            FROM job AS j
            JOIN job_type jt 
                ON job_type_id = jt.id
            JOIN location l 
                ON location_id = l.id
            JOIN employer e 
                ON employer_id = e.id
            WHERE
                job_type_id = $jobType AND
                county = '$location' AND
                j.name LIKE '%$jobKeyword%' 
            "
        );
        $jobQuery->setFetchMode(PDO::FETCH_OBJ);
        $jobQuery->execute();
        if ($jobQuery->rowCount()  > 0) {
            while ($row = $jobQuery->fetch()) {
                $index = rand(2, ($count - 1));
                $filename = $files[$index];
?>
                <div class="job-card col-3">
                    <div class="row">
                        <img class="logo" src="<?php echo 'images/Logos/' . $filename ?>" alt="Employer Logo">
                    </div>
                    <div class="emp-name row">
                        <b><?php echo "<p>" . $row->emp_name . "  ||  " . $row->job_name . "</p>" ?></b>
                    </div>
                    <div class=" job-about row">
                        <?php echo "<p>" . $row->job_about . "</p>" ?>
                    </div>
                    <div class=" job-location-type row">
                        <p>
                            <?php echo "<p>" . $row->job_type . "  ||  " . $row->county . "</p>" ?>
                        </p>
                    </div>
                    <div class="apply-button row">
                        <form method="post" action="home_success.php">
                            <center>
                                <input type="submit" value="Apply" name="applyJob" class="btn btn-outline-primary btn-block">
                                <input value="<?php echo $row->job_id ?>" name="jobId" type="hidden">
                            </center>
                        </form>
                    </div>
                </div>
            <?php

            }
        } else {
            $message = "No results found for this combination.";
            echo   '<span id="userMessage" style="color: green;">' . $message . '</span>';
        }
    }
} else {
    //get all jobs
    $con = new PDO('mysql:host=localhost;dbname=project', $username, $password);
    $allJobQuery = $con->prepare("SELECT j.id as job_id, j.name AS job_name, j.description AS job_about, jt.type AS job_type, l.county AS county, e.name AS emp_name FROM job AS j JOIN job_type jt ON job_type_id = jt.id JOIN location l ON location_id = l.id JOIN employer e ON employer_id = e.id");
    $allJobQuery->setFetchMode(PDO::FETCH_OBJ);
    $allJobQuery->execute();
    if ($allJobQuery->rowCount()  > 0) {
        while ($row = $allJobQuery->fetch()) {
            $index = rand(2, ($count - 1));
            $filename = $files[$index];
            ?>
            <div class="job-card col-3">
                <div class="row">
                    <img class="logo" src="<?php echo 'images/Logos/' . $filename ?>" alt="Employer Logo">
                </div>
                <div class="emp-name row">
                    <b><?php echo "<p>" . $row->emp_name . "  ||  " . $row->job_name . "</p>" ?></b>
                </div>
                <div class=" job-about row">
                    <?php echo "<p>" . $row->job_about . "</p>" ?>
                </div>
                <div class=" job-location-type row">
                    <p>
                        <?php echo "<p>" . $row->job_type . "  ||  " . $row->county . "</p>" ?>
                    </p>
                </div>
                <div class="apply-button row">
                    <form method="post" action="home_success.php">
                        <center>
                            <input class="btn btn-outline-primary btn-block" type="submit" value="Apply" name="applyJob" value="<?php echo $row->job_id ?>" class="btn btn-outline-primary">
                            <input value="<?php echo $row->job_id ?>" name="jobId" type="hidden">
                        </center>
                    </form>
                </div>
            </div>
<?php
        }
    }
}
?>