<?php
include("db1.php");

/* Membership Types */
$q1 = "SELECT * FROM Memberships";
$r1 = mysqli_query($con, $q1) or die(mysqli_error($con));

$memberships = '<table class="section-table">';
while($row = mysqli_fetch_array($r1)){
    $img = "images/membership_" . $row["membership_id"] . ".jpg";
    $memberships .= '
    <tr>
        <td class="c1">
            <div>' . $row["membership_type"] . '</div>
            <img class="thumb" src="' . $img . '" alt="' . $row["membership_type"] . '">
        </td>
        <td class="c2">
            <div>Status: ' . $row["status"] . '</div>
            <div class="subtext">Monthly Price: $' . $row["price"] . '</div>
        </td>
    </tr>';
}
$memberships .= '</table>';

/* About Us - Employees */
$q2 = "SELECT * FROM Employees";
$r2 = mysqli_query($con, $q2) or die(mysqli_error($con));

$employees = '<table class="section-table">';
while($row = mysqli_fetch_array($r2)){
    $img = "images/employee_" . $row["employee_id"] . ".jpg";
    $employees .= '
    <tr>
        <td class="c1">
            <div>' . $row["first_name"] . ' ' . $row["last_name"] . '</div>
            <img class="thumb" src="' . $img . '" alt="' . $row["first_name"] . '">
        </td>
        <td class="c2">
            <div>Position: ' . $row["position"] . '</div>
            <div class="subtext">Hire Date: ' . $row["hire_date"] . '</div>
        </td>
    </tr>';
}
$employees .= '</table>';
?>

<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <title>Final Gym DB - Home</title>
    <link href="style.css" rel="stylesheet" type="text/css" />
</head>
<body>

<div class="navbar">
    <a href="index.php">Home</a>
    <a href="members.php">Members</a>
    <a href="nutrition.php">Nutrition</a>
    <a href="training.php">Training / Classes</a>
</div>

<div class="wrapper">
    <h1>Final Gym Database</h1>

    <h2>Our Gym</h2>
    <div class="hero-gallery">
        <img src="images/gym1.jpg" alt="Gym photo 1">
        <img src="images/gym2.jpg" alt="Gym photo 2">
        <img src="images/gym3.jpg" alt="Gym photo 3">
    </div>

    <h2>Membership Types</h2>
    <?php echo $memberships; ?>

    <h2>Featured Protein Powder</h2>
    <div class="ad-box">
        <div>Build Strength with Our Premium Protein Powder</div>
        <img src="images/product_1.jpg" alt="Protein Powder">
        <div class="subtext">Perfect for recovery, muscle growth, and energy.</div>
    </div>

    <h2>About Us</h2>
    <?php echo $employees; ?>
</div>



</body>
</html>
