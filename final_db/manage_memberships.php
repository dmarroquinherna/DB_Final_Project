<?php
include("db1.php");

$message = "";

/* Query 13: UPDATE */
if (isset($_POST['update_membership'])) {
    $id = mysqli_real_escape_string($con, $_POST['membership_id']);
    $price = mysqli_real_escape_string($con, $_POST['new_price']);

    $update_sql = "UPDATE Memberships
                   SET price = '$price'
                   WHERE membership_id = '$id'";

    if (mysqli_query($con, $update_sql)) {
        $message = "<div class='success'>Membership updated successfully.</div>";
    } else {
        $message = "<div class='error'>Update failed: " . mysqli_error($con) . "</div>";
    }
}

/* Query 14: DELETE */
if (isset($_POST['delete_membership'])) {
    $id = mysqli_real_escape_string($con, $_POST['delete_id']);

    $delete_sql = "DELETE FROM Memberships
                   WHERE membership_id = '$id'";

    if (mysqli_query($con, $delete_sql)) {
        $message = "<div class='success'>Membership deleted successfully.</div>";
    } else {
        $message = "<div class='error'>Delete failed: " . mysqli_error($con) . "</div>";
    }
}

$result = mysqli_query($con, "SELECT * FROM Memberships ORDER BY membership_id") or die(mysqli_error($con));
?>
<html>
<head>
    <title>Manage Memberships</title>
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
    <h1>Manage Memberships</h1>

    <?php echo $message; ?>

    <h2>Update Membership Price</h2>
    <form method="post" class="form-box">
        <label>Membership ID:</label>
        <input type="text" name="membership_id" required>

        <label>New Price:</label>
        <input type="text" name="new_price" required>

        <button type="submit" name="update_membership">Update</button>
    </form>
    <div class="query-box">
        <h3>Query 13 - Update Query</h3>
        <pre>UPDATE Memberships
SET price = 34.99
WHERE membership_id = 1;</pre>
    </div>

    <h2>Delete Membership</h2>
    <form method="post" class="form-box">
        <label>Membership ID:</label>
        <input type="text" name="delete_id" required>

        <button type="submit" name="delete_membership">Delete</button>
    </form>
    <div class="query-box">
        <h3>Query 14 - Delete Query</h3>
        <pre>DELETE FROM Memberships
WHERE membership_id = 5;</pre>
    </div>

    <h2>Current Memberships</h2>
    <table class="section-table">
        <tr>
            <th>ID</th>
            <th>Type</th>
            <th>Status</th>
            <th>Price</th>
        </tr>
        <?php while($row = mysqli_fetch_assoc($result)) { ?>
        <tr>
            <td><?php echo $row['membership_id']; ?></td>
            <td><?php echo $row['membership_type']; ?></td>
            <td><?php echo $row['status']; ?></td>
            <td>$<?php echo $row['price']; ?></td>
        </tr>
        <?php } ?>
    </table>
</div>
</body>
</html>
