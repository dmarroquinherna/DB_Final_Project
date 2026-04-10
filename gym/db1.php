<?php
$con = mysqli_connect("localhost", "root", "root") or die(mysqli_connect_error());
mysqli_set_charset($con, "utf8mb4");
$db = mysqli_select_db($con, "final_db") or die(mysqli_error($con));
?>
