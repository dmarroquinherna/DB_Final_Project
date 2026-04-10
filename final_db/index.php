<?php
include("db1.php");

/* Query 1: General SELECT with ORDER BY */
$q1 = "SELECT membership_id, membership_type, status, price
       FROM Memberships
       ORDER BY price ASC";
$r1 = mysqli_query($con, $q1) or die(mysqli_error($con));

$memberships = '<table class="section-table">';
while($row = mysqli_fetch_assoc($r1)){
    $img = "images/membership_" . $row["membership_id"] . ".jpg";
    $memberships .= '
    <tr>
        <td class="c1">
            <div>' . $row["membership_type"] . '</div>
            <img class="thumb" src="' . $img . '" alt="' . $row["membership_type"] . '">
        </td>
        <td class="c2">
            <div>Status: ' . $row["status"] . '</div>
            <div class="subtext">Price: $' . $row["price"] . '</div>
        </td>
    </tr>';
}
$memberships .= '</table>';

/* Query 2: INNER JOIN */
$q2 = "SELECT c.client_id, c.first_name, c.last_name, m.membership_type, m.price
       FROM Clients c
       INNER JOIN Memberships m
       ON c.Memberships_membership_id = m.membership_id";
$r2 = mysqli_query($con, $q2) or die(mysqli_error($con));

$featured_members = '<table class="section-table">
<tr><th>Client ID</th><th>Name</th><th>Membership</th><th>Price</th></tr>';
while($row = mysqli_fetch_assoc($r2)){
    $featured_members .= '
    <tr>
        <td>' . $row["client_id"] . '</td>
        <td>' . $row["first_name"] . ' ' . $row["last_name"] . '</td>
        <td>' . $row["membership_type"] . '</td>
        <td>$' . $row["price"] . '</td>
    </tr>';
}
$featured_members .= '</table>';

/* Query 3: LEFT JOIN */
$q3 = "SELECT e.employee_id, e.first_name, e.last_name, e.position, cl.class_name, cl.schedule_time
       FROM Employees e
       LEFT JOIN Classes cl
       ON e.employee_id = cl.Employees_employee_id
       ORDER BY e.employee_id";
$r3 = mysqli_query($con, $q3) or die(mysqli_error($con));

$employees_classes = '<table class="section-table">
<tr><th>Employee ID</th><th>Employee</th><th>Position</th><th>Class</th><th>Schedule</th></tr>';
while($row = mysqli_fetch_assoc($r3)){
    $employees_classes .= '
    <tr>
        <td>' . $row["employee_id"] . '</td>
        <td>' . $row["first_name"] . ' ' . $row["last_name"] . '</td>
        <td>' . $row["position"] . '</td>
        <td>' . ($row["class_name"] ? $row["class_name"] : 'No Class Assigned') . '</td>
        <td>' . ($row["schedule_time"] ? $row["schedule_time"] : '-') . '</td>
    </tr>';
}
$employees_classes .= '</table>';

/* About us section */
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
?>
<html>
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
    <a href="manage_memberships.php">Manage Memberships</a>
</div>

<div class="wrapper">
    <h1>Final Gym Database</h1>

    <h2>Our Gym</h2>
    <div class="hero-gallery">
        <img src="images/gym1.jpg" alt="Gym 1">
        <img src="images/gym2.jpg" alt="Gym 2">
        <img src="images/gym3.jpg" alt="Gym 3">
    </div>

    <h2>Membership Types</h2>
    <?php echo $memberships; ?>
    <div class="query-box">
        <h3>Query 1 - General SELECT with ORDER BY</h3>
        <pre>SELECT membership_id, membership_type, status, price
FROM Memberships
ORDER BY price ASC;</pre>
    </div>

    <h2>Featured Members</h2>
    <?php echo $featured_members; ?>
    <div class="query-box">
        <h3>Query 2 - Inner Join</h3>
        <pre>SELECT c.client_id, c.first_name, c.last_name, m.membership_type, m.price
FROM Clients c
INNER JOIN Memberships m
ON c.Memberships_membership_id = m.membership_id;</pre>
    </div>

    <h2>Employee Class Assignments</h2>
    <?php echo $employees_classes; ?>
    <div class="query-box">
        <h3>Query 3 - Outer Join</h3>
        <pre>SELECT e.employee_id, e.first_name, e.last_name, e.position, cl.class_name, cl.schedule_time
FROM Employees e
LEFT JOIN Classes cl
ON e.employee_id = cl.Employees_employee_id
ORDER BY e.employee_id;</pre>
    </div>

    <h2>About Us</h2>
    <?php echo $employees; ?>
</div>

</body>
</html>
