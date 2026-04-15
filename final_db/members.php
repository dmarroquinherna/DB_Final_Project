<?php
include("db1.php");

/* =========================
   QUERY 2: SELECT with WHERE
   Search/filter members
========================= */
$search = isset($_GET['search']) ? $_GET['search'] : '';
$status = isset($_GET['status']) ? $_GET['status'] : '';
$type = isset($_GET['type']) ? $_GET['type'] : '';
$client_id = isset($_GET['client_id']) ? $_GET['client_id'] : '';

$query = "SELECT c.client_id, c.first_name, c.last_name, c.email,
                 m.membership_id, m.membership_type, m.status, m.price
          FROM Clients c
          JOIN Memberships m
          ON c.Memberships_membership_id = m.membership_id
          WHERE 1=1";

if (!empty($search)) {
    $search_safe = mysqli_real_escape_string($con, $search);
    $query .= " AND (c.first_name LIKE '%$search_safe%'
                 OR c.last_name LIKE '%$search_safe%'
                 OR c.email LIKE '%$search_safe%')";
}

if (!empty($status)) {
    $status_safe = mysqli_real_escape_string($con, $status);
    $query .= " AND m.status = '$status_safe'";
}

if (!empty($type)) {
    $type_safe = mysqli_real_escape_string($con, $type);
    $query .= " AND m.membership_type = '$type_safe'";
}

if (!empty($client_id)) {
    $client_id_safe = mysqli_real_escape_string($con, $client_id);
    $query .= " AND c.client_id = '$client_id_safe'";
}

$result = mysqli_query($con, $query) or die(mysqli_error($con));

$members = '<table class="section-table">
<tr>
<th>Client ID</th><th>Name</th><th>Email</th>
<th>Membership ID</th><th>Type</th><th>Status</th><th>Price</th>
</tr>';

while($row = mysqli_fetch_assoc($result)){
    $members .= '
    <tr>
        <td>'.$row["client_id"].'</td>
        <td>'.$row["first_name"].' '.$row["last_name"].'</td>
        <td>'.$row["email"].'</td>
        <td>'.$row["membership_id"].'</td>
        <td>'.$row["membership_type"].'</td>
        <td>'.$row["status"].'</td>
        <td>$'.$row["price"].'</td>
    </tr>';
}

$members .= '</table>';

/* =========================
   QUERY 10: SUBQUERY
========================= */
$q_sub = "SELECT DISTINCT c.first_name, c.last_name
          FROM Clients c
          JOIN Invoices i
          ON c.client_id = i.Clients_client_id
          WHERE i.total_amount > (
              SELECT AVG(total_amount)
              FROM Invoices
          )";

$r_sub = mysqli_query($con, $q_sub) or die(mysqli_error($con));

$subquery_members = '<table class="section-table">
<tr><th>First Name</th><th>Last Name</th></tr>';

while($row = mysqli_fetch_assoc($r_sub)){
    $subquery_members .= '
    <tr>
        <td>'.$row["first_name"].'</td>
        <td>'.$row["last_name"].'</td>
    </tr>';
}

$subquery_members .= '</table>';

/* =========================
   QUERY 14: CASE FUNCTION
========================= */
$q_case = "SELECT c.client_id, c.first_name, c.last_name,
                  CASE
                      WHEN c.Memberships_membership_id = 1 THEN 'Basic Member'
                      WHEN c.Memberships_membership_id = 2 THEN 'Premium Member'
                      WHEN c.Memberships_membership_id = 3 THEN 'Student Member'
                      WHEN c.Memberships_membership_id = 4 THEN 'VIP Member'
                      ELSE 'Other Membership'
                  END AS member_level
           FROM Clients c";

$r_case = mysqli_query($con, $q_case) or die(mysqli_error($con));

$case_members = '<table class="section-table">
<tr><th>Client ID</th><th>Name</th><th>Member Level</th></tr>';

while($row = mysqli_fetch_assoc($r_case)){
    $case_members .= '
    <tr>
        <td>'.$row["client_id"].'</td>
        <td>'.$row["first_name"].' '.$row["last_name"].'</td>
        <td>'.$row["member_level"].'</td>
    </tr>';
}

$case_members .= '</table>';

/* =========================
   EXTRA UI: Classes enrolled
========================= */
$q_classes = "SELECT c.first_name, c.last_name, cl.class_name, cl.schedule_time
              FROM Class_Registrations cr
              JOIN Clients c
              ON cr.Clients_client_id = c.client_id
              JOIN Classes cl
              ON cr.Classes_class_id = cl.class_id
              ORDER BY c.last_name, c.first_name";

$r_classes = mysqli_query($con, $q_classes) or die(mysqli_error($con));

$registrations = '<table class="section-table">
<tr><th>Member</th><th>Class</th><th>Schedule</th></tr>';

while($row = mysqli_fetch_assoc($r_classes)){
    $registrations .= '
    <tr>
        <td>'.$row["first_name"].' '.$row["last_name"].'</td>
        <td>'.$row["class_name"].'</td>
        <td>'.$row["schedule_time"].'</td>
    </tr>';
}

$registrations .= '</table>';

/* =========================
   EXTRA UI: Invoices
========================= */
$q_invoices = "SELECT i.invoice_id, i.payment_date, i.total_amount,
                      c.first_name, c.last_name
               FROM Invoices i
               JOIN Clients c
               ON i.Clients_client_id = c.client_id
               ORDER BY i.invoice_id";

$r_invoices = mysqli_query($con, $q_invoices) or die(mysqli_error($con));

$invoices = '<table class="section-table">
<tr><th>Invoice #</th><th>Client</th><th>Date</th><th>Total</th></tr>';

while($row = mysqli_fetch_assoc($r_invoices)){
    $invoices .= '
    <tr>
        <td>'.$row["invoice_id"].'</td>
        <td>'.$row["first_name"].' '.$row["last_name"].'</td>
        <td>'.$row["payment_date"].'</td>
        <td>$'.$row["total_amount"].'</td>
    </tr>';
}

$invoices .= '</table>';
?>
<html>
<head>
    <title>Members</title>
    <link href="style.css" rel="stylesheet">
    <style>
        .dropdown-box{
            margin: 18px 0 28px 0;
            background: white;
            border: 2px solid cadetblue;
            border-radius: 8px;
            overflow: hidden;
        }

        .dropdown-box summary{
            cursor: pointer;
            padding: 14px 16px;
            font-size: 22px;
            font-family: cursive;
            color: cadetblue;
            background: #f8f3ea;
            font-weight: bold;
        }

        .dropdown-content{
            padding: 16px;
        }

        .query-box{
            background-color: #f7f2e8;
            border-left: 4px solid cadetblue;
            padding: 12px;
            margin: 12px 0 10px 0;
        }

        .query-box h3{
            margin-top: 0;
            color: brown;
        }

        .query-box p{
            margin-bottom: 0;
        }

        pre{
            white-space: pre-wrap;
            font-family: Consolas, monospace;
            font-size: 14px;
        }
    </style>
</head>
<body>

<div class="navbar">
    <a href="index.php">Home</a>
    <a href="members.php">Members</a>
    <a href="nutrition.php">Nutrition</a>
    <a href="training.php">Training</a>
    <a href="manage_memberships.php">Manage Memberships</a>
</div>

<div class="wrapper">

    <h1>Members</h1>

    <h2>Search Members</h2>
    <form method="GET" class="form-box">
        <label>Search Name or Email:</label>
        <input type="text" name="search" placeholder="Enter name or email" value="<?php echo htmlspecialchars($search); ?>">

        <label>Status:</label>
        <select name="status">
            <option value="">All</option>
            <option value="Active" <?php if($status=='Active') echo 'selected'; ?>>Active</option>
            <option value="Inactive" <?php if($status=='Inactive') echo 'selected'; ?>>Inactive</option>
        </select>

        <label>Membership Type:</label>
        <select name="type">
            <option value="">All</option>
            <option value="Basic" <?php if($type=='Basic') echo 'selected'; ?>>Basic</option>
            <option value="Premium" <?php if($type=='Premium') echo 'selected'; ?>>Premium</option>
            <option value="Student" <?php if($type=='Student') echo 'selected'; ?>>Student</option>
            <option value="VIP" <?php if($type=='VIP') echo 'selected'; ?>>VIP</option>
            <option value="Family" <?php if($type=='Family') echo 'selected'; ?>>Family</option>
            <option value="Weekend" <?php if($type=='Weekend') echo 'selected'; ?>>Weekend</option>
            <option value="Senior" <?php if($type=='Senior') echo 'selected'; ?>>Senior</option>
            <option value="Corporate" <?php if($type=='Corporate') echo 'selected'; ?>>Corporate</option>
            <option value="Trial" <?php if($type=='Trial') echo 'selected'; ?>>Trial</option>
            <option value="Athlete" <?php if($type=='Athlete') echo 'selected'; ?>>Athlete</option>
        </select>

        <label>Client ID:</label>
        <input type="text" name="client_id" placeholder="Enter Client ID" value="<?php echo htmlspecialchars($client_id); ?>">

        <button type="submit">Search</button>
    </form>

    <a href="members.php">Reset Filters</a>

    <details class="dropdown-box" open>
        <summary>Search Results</summary>
        <div class="dropdown-content">
            <?php echo $members; ?>

            <div class="query-box">
                <h3>Query 2 - SELECT with a WHERE Clause</h3>
                <pre><?php echo htmlspecialchars($query); ?></pre>
                <p>
                    This query retrieves client information together with membership details by joining the
                    Clients and Memberships tables. The WHERE clause is built dynamically from the search form
                    so employees can filter by name or email, membership status, membership type, and client ID.
                    This makes it useful for quickly locating specific members in a gym POS system.
                </p>
            </div>
        </div>
    </details>

    <details class="dropdown-box">
        <summary>Members with Above-Average Invoices</summary>
        <div class="dropdown-content">
            <?php echo $subquery_members; ?>

            <div class="query-box">
                <h3>Query 10 - Subquery</h3>
                <pre><?php echo htmlspecialchars($q_sub); ?></pre>
                <p>
                    This query uses a subquery to find the average invoice total from the Invoices table.
                    The outer query then returns clients whose invoice amount is greater than that average.
                    It is useful for identifying higher-spending members.
                </p>
            </div>
        </div>
    </details>

    <details class="dropdown-box">
        <summary>Membership Labels</summary>
        <div class="dropdown-content">
            <?php echo $case_members; ?>

            <div class="query-box">
                <h3>Query 14 - CASE Function</h3>
                <pre><?php echo htmlspecialchars($q_case); ?></pre>
                <p>
                    This query uses a CASE expression to convert membership IDs into readable labels such as
                    Basic Member, Premium Member, Student Member, and VIP Member. It improves readability for
                    employees by showing meaningful membership levels instead of only numeric IDs.
                </p>
            </div>
        </div>
    </details>

    <details class="dropdown-box">
        <summary>Classes Enrolled</summary>
        <div class="dropdown-content">
            <?php echo $registrations; ?>
        </div>
    </details>

    <details class="dropdown-box">
        <summary>Invoices</summary>
        <div class="dropdown-content">
            <?php echo $invoices; ?>
        </div>
    </details>

</div>

</body>
</html>
