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
            <h1>Contact Details</h1>
        </div>
        <br>
        <div class="row">
            <div class="col-4">
                <p id="about-content">
                    please write your queries, or report an error to joshua.pereira@ucdconnect.ie
                </p>
            </div>
            <div class="col-4">

            </div>
            <div class="col-4">

            </div>
        </div>
        <br>
        <div>
            <a href="javascript:history.back()" class="btn btn-outline-primary">
                Click here to go Back
            </a>
        </div>
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