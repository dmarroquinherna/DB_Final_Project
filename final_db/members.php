<?php
include("db1.php");

/* Query 4: SELECT with WHERE */
$q1 = "SELECT client_id, first_name, last_name, email, city, state
       FROM Clients
       WHERE state = 'MI'";
$r1 = mysqli_query($con, $q1) or die(mysqli_error($con));

$clients_where = '<table class="section-table">
<tr><th>Client ID</th><th>Name</th><th>Email</th><th>City</th><th>State</th></tr>';
while($row = mysqli_fetch_assoc($r1)){
    $clients_where .= '
    <tr>
        <td>' . $row["client_id"] . '</td>
        <td>' . $row["first_name"] . ' ' . $row["last_name"] . '</td>
        <td>' . $row["email"] . '</td>
        <td>' . $row["city"] . '</td>
        <td>' . $row["state"] . '</td>
    </tr>';
}
$clients_where .= '</table>';

/* Query 5: Subquery */
$q2 = "SELECT first_name, last_name
       FROM Clients
       WHERE client_id IN (
           SELECT Clients_client_id
           FROM Invoices
           WHERE total_amount > (
               SELECT AVG(total_amount)
               FROM Invoices
           )
       )";
$r2 = mysqli_query($con, $q2) or die(mysqli_error($con));

$subquery_members = '<table class="section-table">
<tr><th>First Name</th><th>Last Name</th></tr>';
while($row = mysqli_fetch_assoc($r2)){
    $subquery_members .= '
    <tr>
        <td>' . $row["first_name"] . '</td>
        <td>' . $row["last_name"] . '</td>
    </tr>';
}
$subquery_members .= '</table>';

/* Query 6: CASE */
$q3 = "SELECT c.first_name, c.last_name,
              CASE
                  WHEN c.Memberships_membership_id = 1 THEN 'Basic Member'
                  WHEN c.Memberships_membership_id = 2 THEN 'Premium Member'
                  WHEN c.Memberships_membership_id = 3 THEN 'Student Member'
                  ELSE 'VIP / Other'
              END AS member_level
       FROM Clients c";
$r3 = mysqli_query($con, $q3) or die(mysqli_error($con));

$case_members = '<table class="section-table">
<tr><th>Name</th><th>Member Level</th></tr>';
while($row = mysqli_fetch_assoc($r3)){
    $case_members .= '
    <tr>
        <td>' . $row["first_name"] . ' ' . $row["last_name"] . '</td>
        <td>' . $row["member_level"] . '</td>
    </tr>';
}
$case_members .= '</table>';

/* Extra members info UI */
$q4 = "SELECT c.client_id, c.first_name, c.last_name, c.email,
              m.membership_type, m.status, m.price
       FROM Clients c
       JOIN Memberships m
       ON c.Memberships_membership_id = m.membership_id";
$r4 = mysqli_query($con, $q4) or die(mysqli_error($con));

$memberships = '<table class="section-table">
<tr><th>ID</th><th>Name</th><th>Email</th><th>Plan</th><th>Status</th><th>Price</th></tr>';
while($row = mysqli_fetch_assoc($r4)){
    $memberships .= '
    <tr>
        <td>' . $row["client_id"] . '</td>
        <td>' . $row["first_name"] . ' ' . $row["last_name"] . '</td>
        <td>' . $row["email"] . '</td>
        <td>' . $row["membership_type"] . '</td>
        <td>' . $row["status"] . '</td>
        <td>$' . $row["price"] . '</td>
    </tr>';
}
$memberships .= '</table>';

/* Classes enrolled */
$q5 = "SELECT c.first_name, c.last_name, cl.class_name, cl.schedule_time
       FROM Class_Registrations cr
       JOIN Clients c
         ON cr.Clients_client_id = c.client_id
       JOIN Classes cl
         ON cr.Classes_class_id = cl.class_id
       ORDER BY c.last_name";
$r5 = mysqli_query($con, $q5) or die(mysqli_error($con));

$registrations = '<table class="section-table">
<tr><th>Member</th><th>Class</th><th>Schedule</th></tr>';
while($row = mysqli_fetch_assoc($r5)){
    $registrations .= '
    <tr>
        <td>' . $row["first_name"] . ' ' . $row["last_name"] . '</td>
        <td>' . $row["class_name"] . '</td>
        <td>' . $row["schedule_time"] . '</td>
    </tr>';
}
$registrations .= '</table>';

/* Invoices */
$q6 = "SELECT i.invoice_id, i.payment_date, i.total_amount,
              c.first_name, c.last_name
       FROM Invoices i
       JOIN Clients c
       ON i.Clients_client_id = c.client_id
       ORDER BY i.invoice_id";
$r6 = mysqli_query($con, $q6) or die(mysqli_error($con));

$invoices = '<table class="section-table">
<tr><th>Invoice #</th><th>Client</th><th>Date</th><th>Total</th></tr>';
while($row = mysqli_fetch_assoc($r6)){
    $invoices .= '
    <tr>
        <td>' . $row["invoice_id"] . '</td>
        <td>' . $row["first_name"] . ' ' . $row["last_name"] . '</td>
        <td>' . $row["payment_date"] . '</td>
        <td>$' . $row["total_amount"] . '</td>
    </tr>';
}
$invoices .= '</table>';
?>
<html>
<head>
    <title>Final Gym DB - Members</title>
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
    <h1>Members Page</h1>

    <h2>Membership Status</h2>
    <?php echo $memberships; ?>

    <h2>Members from Michigan</h2>
    <?php echo $clients_where; ?>
    <div class="query-box">
        <h3>Query 4 - SELECT with WHERE</h3>
        <pre>SELECT client_id, first_name, last_name, email, city, state
FROM Clients
WHERE state = 'MI';</pre>
    </div>

    <h2>Members with Above-Average Invoices</h2>
    <?php echo $subquery_members; ?>
    <div class="query-box">
        <h3>Query 5 - Subquery</h3>
        <pre>SELECT first_name, last_name
FROM Clients
WHERE client_id IN (
    SELECT Clients_client_id
    FROM Invoices
    WHERE total_amount > (
        SELECT AVG(total_amount)
        FROM Invoices
    )
);</pre>
    </div>

    <h2>Membership Labels</h2>
    <?php echo $case_members; ?>
    <div class="query-box">
        <h3>Query 6 - CASE Function</h3>
        <pre>SELECT c.first_name, c.last_name,
       CASE
           WHEN c.Memberships_membership_id = 1 THEN 'Basic Member'
           WHEN c.Memberships_membership_id = 2 THEN 'Premium Member'
           WHEN c.Memberships_membership_id = 3 THEN 'Student Member'
           ELSE 'VIP / Other'
       END AS member_level
FROM Clients c;</pre>
    </div>

    <h2>Classes Enrolled</h2>
    <?php echo $registrations; ?>

    <h2>Invoices</h2>
    <?php echo $invoices; ?>
</div>

</body>
</html>
