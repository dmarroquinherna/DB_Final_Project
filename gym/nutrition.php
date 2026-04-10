<?php
include("db1.php");

$q1 = "SELECT * FROM Nutrition_Products";
$r1 = mysqli_query($con, $q1) or die(mysqli_error($con));

$nutrition = '<table class="section-table">';
while($row = mysqli_fetch_array($r1)){
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

<html xmlns="http://www.w3.org/1999/xhtml">
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
</div>

<div class="wrapper">
    <h1>Nutrition Page</h1>

    <h2>Ingredients and Nutrition Info</h2>
    <?php echo $nutrition; ?>

    <h2>Smoothie Bar Menu</h2>
    <div class="ad-box">
        <div>Try our post-workout smoothies and gym snacks</div>
        <div></div>
    </div>
</div>


</body>
</html>
