<?php
session_start();
require_once("inc_OnlineStoreDB.php");

if (!isset($_GET['orderID'])) {
    header("Location: ViewOrders.php");
    exit();
}

$orderID = intval($_GET['orderID']);
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>Order Details</title>
<link rel="stylesheet" href="GosselinGourmetGoods.css" type="text/css" />
</head>
<body>
<div class="welcome-container">
    <h1>Order #<?php echo $orderID; ?> - Details</h1>

    <?php
    // Get order information
    $SQLorder = "SELECT * FROM orders WHERE orderID=$orderID";
    $OrderResult = @$DBConnect->query($SQLorder);

    if ($OrderResult && $OrderRow = $OrderResult->fetch_assoc()) {
        echo "<div class='category-section'>";
        echo "<p><strong>Order Date:</strong> {$OrderRow['order_date']}</p>";
        echo "<p><strong>Client ID:</strong> {$OrderRow['clientID']}</p>";
        echo "</div>";
        
        // Get items in this order
        $SQLitems = "SELECT oi.productID, oi.quantity, i.name, i.description, i.price 
                     FROM orders_inventory oi
                     INNER JOIN inventory i ON oi.productID = i.productID
                     WHERE oi.orderID = $orderID";
        $ItemsResult = @$DBConnect->query($SQLitems);
        
        if ($ItemsResult && $ItemsResult->num_rows > 0) {
            echo "<h3>Items Ordered:</h3>";
            echo "<table width='100%' border='1'>";
            echo "<tr><th>Product ID</th><th>Product Name</th><th>Description</th><th>Price Each</th><th>Quantity</th><th>Subtotal</th></tr>";
            
            $total = 0;
            while ($Item = $ItemsResult->fetch_assoc()) {
                $subtotal = $Item['price'] * $Item['quantity'];
                $total += $subtotal;
                
                echo "<tr>";
                echo "<td>{$Item['productID']}</td>";
                echo "<td>{$Item['name']}</td>";
                echo "<td>{$Item['description']}</td>";
                printf("<td align='center'>R%.2f</td>", $Item['price']);
                echo "<td align='center'>{$Item['quantity']}</td>";
                printf("<td align='center'>R%.2f</td>", $subtotal);
                echo "</tr>";
            }
            
            echo "<tr><td colspan='5' align='right'><strong>Total:</strong></td>";
            printf("<td align='center'><strong>R%.2f</strong></td></tr>", $total);
            echo "</table>";
        } else {
            echo "<p style='text-align: center; color: #6B4423;'>No items found for this order.</p>";
        }
    } else {
        echo "<p style='text-align: center; color: #6B4423;'>Order not found.</p>";
    }
    ?>

    <p style="text-align: center; margin-top: 30px;">
        <a href="ViewOrders.php?PHPSESSID=<?php echo session_id(); ?>">← Back to Orders</a> | 
        <a href="GosselinGourmetGoods.php">Home</a>
    </p>
</div>
</body>
</html>