<?php
session_start();
session_destroy();
header("location:jobify.php");
