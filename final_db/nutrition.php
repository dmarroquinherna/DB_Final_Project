<?php
include("db1.php");

$message = "";

/* Query 9: INSERT */
if (isset($_POST['insert_product'])) {
    $product_name = mysqli_real_escape_string($con, $_POST['product_name']);
    $price = mysqli_real_escape_string($con, $_POST['price']);
    $description = mysqli_real_escape_string($con, $_POST['description']);
    $invoice_id = mysqli_real_escape_string($con, $_POST['invoice_id']);

    $insert_sql = "INSERT INTO Nutrition_Products (product_name, price, description, Invoices_invoice_id)
                   VALUES ('$product_name', '$price', '$description', '$invoice_id')";

    if (mysqli_query($con, $insert_sql)) {
        $message = "<div class='success'>Nutrition product inserted successfully.</div>";
    } else {
        $message = "<div class='error'>Insert failed: " . mysqli_error($con) . "</div>";
    }
}

/* Query 7: String function */
$q1 = "SELECT product_id, product_name,
              UPPER(description) AS ingredients_info,
              price
       FROM Nutrition_Products";
$r1 = mysqli_query($con, $q1) or die(mysqli_error($con));

$string_products = '<table class="section-table">
<tr><th>ID</th><th>Product</th><th>Ingredients / Info</th><th>Price</th></tr>';
while($row = mysqli_fetch_assoc($r1)){
    $string_products .= '
    <tr>
        <td>' . $row["product_id"] . '</td>
        <td>' . $row["product_name"] . '</td>
        <td>' . $row["ingredients_info"] . '</td>
        <td>$' . $row["price"] . '</td>
    </tr>';
}
$string_products .= '</table>';

/* Query 8: Numeric function */
$q2 = "SELECT product_id, product_name, price,
              ROUND(price * 1.06, 2) AS price_with_tax
       FROM Nutrition_Products";
$r2 = mysqli_query($con, $q2) or die(mysqli_error($con));

$numeric_products = '<table class="section-table">
<tr><th>ID</th><th>Product</th><th>Base Price</th><th>Price With Tax</th></tr>';
while($row = mysqli_fetch_assoc($r2)){
    $numeric_products .= '
    <tr>
        <td>' . $row["product_id"] . '</td>
        <td>' . $row["product_name"] . '</td>
        <td>$' . $row["price"] . '</td>
        <td>$' . $row["price_with_tax"] . '</td>
    </tr>';
}
$numeric_products .= '</table>';

/* Main nutrition menu */
$q3 = "SELECT * FROM Nutrition_Products";
$r3 = mysqli_query($con, $q3) or die(mysqli_error($con));

$nutrition = '<table class="section-table">';
while($row = mysqli_fetch_assoc($r3)){
    $img = "images/product_" . $row["product_id"] . ".jpg";
    $nutrition .= '
    <tr>
        <td class="c1">
            <div>' . $row["product_name"] . '</div>
            <img class="thumb" src="' . $img . '" alt="' . $row["product_name"] . '">
        </td>
        <td class="c2">
            <div>Ingredients / Info:</div>
            <div>' . $row["description"] . '</div>
            <div class="subtext">Menu Price: $' . $row["price"] . '</div>
        </td>
    </tr>';
}
$nutrition .= '</table>';
?>
<html>
<head>
    <title>Final Gym DB - Nutrition</title>
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
    <h1>Nutrition Page</h1>

    <?php echo $message; ?>

    <h2>Ingredients and Nutrition Info</h2>
    <?php echo $nutrition; ?>

    <h2>String Function Display</h2>
    <?php echo $string_products; ?>
    <div class="query-box">
        <h3>Query 7 - String Function</h3>
        <pre>SELECT product_id, product_name,
       UPPER(description) AS ingredients_info,
       price
FROM Nutrition_Products;</pre>
    </div>

    <h2>Numeric Function Display</h2>
    <?php echo $numeric_products; ?>
    <div class="query-box">
        <h3>Query 8 - Numeric Function</h3>
        <pre>SELECT product_id, product_name, price,
       ROUND(price * 1.06, 2) AS price_with_tax
FROM Nutrition_Products;</pre>
    </div>

    <h2>Insert New Nutrition Product</h2>
    <form method="post" class="form-box">
        <label>Product Name:</label>
        <input type="text" name="product_name" required>

        <label>Price:</label>
        <input type="text" name="price" required>

        <label>Description / Ingredients:</label>
        <input type="text" name="description" required>

        <label>Invoice ID:</label>
        <input type="text" name="invoice_id" required>

        <button type="submit" name="insert_product">Insert Product</button>
    </form>
    <div class="query-box">
        <h3>Query 9 - Insert Query</h3>
        <pre>INSERT INTO Nutrition_Products (product_name, price, description, Invoices_invoice_id)
VALUES ('Protein Shake', 8.99, 'Banana, whey protein, almond milk', 1);</pre>
    </div>

</body>
</html>
