<?php
include("db1.php");

/* Employees */
$q1 = "SELECT * FROM Employees";
$r1 = mysqli_query($con, $q1) or die(mysqli_error($con));

$employees = '<table class="section-table">';
while($row = mysqli_fetch_array($r1)){
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

/* Classes */
$q2 = "SELECT cl.class_name, cl.schedule_time,
              e.first_name, e.last_name
       FROM Classes cl
       JOIN Employees e
       ON cl.Employees_employee_id = e.employee_id";
$r2 = mysqli_query($con, $q2) or die(mysqli_error($con));

$classes = '<table class="section-table">';
while($row = mysqli_fetch_array($r2)){
    $classes .= '
    <tr>
        <td class="c3">' . $row["class_name"] . '</td>
        <td class="c4">
            <div>Instructor: ' . $row["first_name"] . ' ' . $row["last_name"] . '</div>
            <div class="subtext">Schedule: ' . $row["schedule_time"] . '</div>
        </td>
    </tr>';
}
$classes .= '</table>';

/* Equipment */
$q3 = "SELECT * FROM Equipment";
$r3 = mysqli_query($con, $q3) or die(mysqli_error($con));

$equipment = '<table class="section-table">';
while($row = mysqli_fetch_array($r3)){
    $img = "images/equipment_" . $row["equipment_id"] . ".jpg";
    $equipment .= '
    <tr>
        <td class="c1">
            <div>' . $row["type"] . '</div>
            <img class="thumb" src="' . $img . '" alt="' . $row["type"] . '">
        </td>
        <td class="c2">
            <div>Equipment Type: ' . $row["type"] . '</div>
            <div class="subtext">Last Maintenance: ' . $row["last_maintenance_date"] . '</div>
        </td>
    </tr>';
}
$equipment .= '</table>';
?>

<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <title>Final Gym DB - Training and Classes</title>
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
    <h1>Training / Classes Page</h1>

    <h2>Employee Information</h2>
    <?php echo $employees; ?>

    <h2>Classes</h2>
    <?php echo $classes; ?>

    <h2>Equipment</h2>
    <?php echo $equipment; ?>
</div>


</body>
</html>
