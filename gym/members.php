<?php
include("db1.php");

/* Member Info */
$q1 = "SELECT c.client_id, c.first_name, c.last_name, c.email,
              m.membership_type, m.status, m.price
       FROM Clients c
       JOIN Memberships m
       ON c.Memberships_membership_id = m.membership_id";
$r1 = mysqli_query($con, $q1) or die(mysqli_error($con));

$members = '<table class="section-table">';
while($row = mysqli_fetch_array($r1)){
    $members .= '
    <tr>
        <td class="c3">Member #' . $row["client_id"] . '</td>
        <td class="c4">
            <div>' . $row["first_name"] . ' ' . $row["last_name"] . '</div>
            <div>Email: ' . $row["email"] . '</div>
            <div class="subtext">Plan: ' . $row["membership_type"] . ' | Status: ' . $row["status"] . ' | $' . $row["price"] . '</div>
        </td>
    </tr>';
}
$members .= '</table>';

/* Classes Enrolled */
$q2 = "SELECT c.first_name, c.last_name, cl.class_name, cl.schedule_time
       FROM Class_Registrations cr
       JOIN Clients c
         ON cr.Clients_client_id = c.client_id
       JOIN Classes cl
         ON cr.Classes_class_id = cl.class_id
       ORDER BY c.last_name";
$r2 = mysqli_query($con, $q2) or die(mysqli_error($con));

$registrations = '<table class="section-table">';
while($row = mysqli_fetch_array($r2)){
    $registrations .= '
    <tr>
        <td class="c3">' . $row["class_name"] . '</td>
        <td class="c4">
            <div>Member: ' . $row["first_name"] . ' ' . $row["last_name"] . '</div>
            <div class="subtext">Schedule: ' . $row["schedule_time"] . '</div>
        </td>
    </tr>';
}
$registrations .= '</table>';

/* Invoices */
$q3 = "SELECT i.invoice_id, i.payment_date, i.total_amount,
              c.first_name, c.last_name
       FROM Invoices i
       JOIN Clients c
       ON i.Clients_client_id = c.client_id
       ORDER BY i.invoice_id";
$r3 = mysqli_query($con, $q3) or die(mysqli_error($con));

$invoices = '<table class="section-table">';
while($row = mysqli_fetch_array($r3)){
    $invoices .= '
    <tr>
        <td class="c3">Invoice #' . $row["invoice_id"] . '</td>
        <td class="c4">
            <div>Client: ' . $row["first_name"] . ' ' . $row["last_name"] . '</div>
            <div class="subtext">Date: ' . $row["payment_date"] . ' | Total: $' . $row["total_amount"] . '</div>
        </td>
    </tr>';
}
$invoices .= '</table>';
?>

<html xmlns="http://www.w3.org/1999/xhtml">
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
</div>

<div class="wrapper">
    <h1>Members Page</h1>

    <h2>Membership Status</h2>
    <?php echo $members; ?>

    <h2>Classes Enrolled</h2>
    <?php echo $registrations; ?>

    <h2>Invoices</h2>
    <?php echo $invoices; ?>
</div>


</body>
</html>
