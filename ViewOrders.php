<?php
session_start();
require_once("inc_OnlineStoreDB.php");
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>My Orders</title>
<link rel="stylesheet" href="GosselinGourmetGoods.css" type="text/css" />
</head>
<body>
<div class="welcome-container">
    <h1>My Orders</h1>
    <?php
    // Get all orders for this user (using 'guest' as clientID)
    $SQLstring = "SELECT * FROM orders WHERE clientID='guest' ORDER BY order_date DESC";
    $QueryResult = @$DBConnect->query($SQLstring);

    if ($QueryResult && $QueryResult->num_rows > 0) {
        echo "<table width='100%' border='1'>";
        echo "<tr><th>Order ID</th><th>Order Date</th><th>View Details</th></tr>";
        
        while ($Row = $QueryResult->fetch_assoc()) {
            echo "<tr>";
            echo "<td align='center'>{$Row['orderID']}</td>";
            echo "<td align='center'>{$Row['order_date']}</td>";
            echo "<td align='center'><a href='ViewOrderDetails.php?PHPSESSID=" . session_id() . 
                 "&orderID=" . $Row['orderID'] . "'>View Items</a></td>";
            echo "</tr>";
        }
        
        echo "</table>";
    } else {
        echo "<p style='text-align: center; font-size: 1.2em; color: #6B4423;'>You have no orders yet.</p>";
        echo "<p style='text-align: center;'><a href='GosselinGourmetGoods.php'>Start Shopping!</a></p>";
    }
    ?>
    <p style="text-align: center; margin-top: 30px;">
        <a href="GosselinGourmetGoods.php">← Return to Home</a>
    </p>
</div>
</body>
</html>
