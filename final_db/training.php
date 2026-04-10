<?php
include("db1.php");

/* Query 10: Aggregate function */
$q1 = "SELECT COUNT(*) AS total_classes
       FROM Classes";
$r1 = mysqli_query($con, $q1) or die(mysqli_error($con));
$total_classes = mysqli_fetch_assoc($r1);

/* Query 11: GROUP BY and HAVING */
$q2 = "SELECT e.first_name, e.last_name, COUNT(cl.class_id) AS number_of_classes
       FROM Employees e
       LEFT JOIN Classes cl
       ON e.employee_id = cl.Employees_employee_id
       GROUP BY e.employee_id, e.first_name, e.last_name
       HAVING COUNT(cl.class_id) >= 1";
$r2 = mysqli_query($con, $q2) or die(mysqli_error($con));

$grouped_classes = '<table class="section-table">
<tr><th>Trainer</th><th>Number of Classes</th></tr>';
while($row = mysqli_fetch_assoc($r2)){
    $grouped_classes .= '
    <tr>
        <td>' . $row["first_name"] . ' ' . $row["last_name"] . '</td>
        <td>' . $row["number_of_classes"] . '</td>
    </tr>';
}
$grouped_classes .= '</table>';

/* Query 12: Date function */
$q3 = "SELECT equipment_id, type, last_maintenance_date,
              DATEDIFF(CURDATE(), last_maintenance_date) AS days_since_maintenance
       FROM Equipment";
$r3 = mysqli_query($con, $q3) or die(mysqli_error($con));

$equipment_dates = '<table class="section-table">
<tr><th>Equipment ID</th><th>Type</th><th>Last Maintenance</th><th>Days Since Maintenance</th></tr>';
while($row = mysqli_fetch_assoc($r3)){
    $equipment_dates .= '
    <tr>
        <td>' . $row["equipment_id"] . '</td>
        <td>' . $row["type"] . '</td>
        <td>' . $row["last_maintenance_date"] . '</td>
        <td>' . $row["days_since_maintenance"] . '</td>
    </tr>';
}
$equipment_dates .= '</table>';

/* Employees */
$q4 = "SELECT * FROM Employees";
$r4 = mysqli_query($con, $q4) or die(mysqli_error($con));

$employees = '<table class="section-table">';
while($row = mysqli_fetch_assoc($r4)){
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
$q5 = "SELECT cl.class_name, cl.schedule_time, e.first_name, e.last_name
       FROM Classes cl
       JOIN Employees e
       ON cl.Employees_employee_id = e.employee_id";
$r5 = mysqli_query($con, $q5) or die(mysqli_error($con));

$classes = '<table class="section-table">
<tr><th>Class</th><th>Instructor</th><th>Schedule</th></tr>';
while($row = mysqli_fetch_assoc($r5)){
    $classes .= '
    <tr>
        <td>' . $row["class_name"] . '</td>
        <td>' . $row["first_name"] . ' ' . $row["last_name"] . '</td>
        <td>' . $row["schedule_time"] . '</td>
    </tr>';
}
$classes .= '</table>';

/* Equipment */
$q6 = "SELECT * FROM Equipment";
$r6 = mysqli_query($con, $q6) or die(mysqli_error($con));

$equipment = '<table class="section-table">';
while($row = mysqli_fetch_assoc($r6)){
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
<html>
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
    <a href="manage_memberships.php">Manage Memberships</a>
</div>

<div class="wrapper">
    <h1>Training / Classes Page</h1>

    <h2>Employee Information</h2>
    <?php echo $employees; ?>

    <h2>Classes</h2>
    <?php echo $classes; ?>

    <h2>Total Number of Classes</h2>
    <table class="section-table">
        <tr><th>Total Classes</th></tr>
        <tr><td><?php echo $total_classes["total_classes"]; ?></td></tr>
    </table>
    <div class="query-box">
        <h3>Query 10 - Aggregate Function</h3>
        <pre>SELECT COUNT(*) AS total_classes
FROM Classes;</pre>
    </div>

    <h2>Trainers with One or More Classes</h2>
    <?php echo $grouped_classes; ?>
    <div class="query-box">
        <h3>Query 11 - GROUP BY and HAVING</h3>
        <pre>SELECT e.first_name, e.last_name, COUNT(cl.class_id) AS number_of_classes
FROM Employees e
LEFT JOIN Classes cl
ON e.employee_id = cl.Employees_employee_id
GROUP BY e.employee_id, e.first_name, e.last_name
HAVING COUNT(cl.class_id) >= 1;</pre>
    </div>

    <h2>Equipment Maintenance Tracker</h2>
    <?php echo $equipment_dates; ?>
    <div class="query-box">
        <h3>Query 12 - Date Function</h3>
        <pre>SELECT equipment_id, type, last_maintenance_date,
       DATEDIFF(CURDATE(), last_maintenance_date) AS days_since_maintenance
FROM Equipment;</pre>
    </div>

    <h2>Equipment</h2>
    <?php echo $equipment; ?>
</div>

</body>
</html>
