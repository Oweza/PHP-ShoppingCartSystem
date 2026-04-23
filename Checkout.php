<?php
session_start();
require_once("ShoppingCart.php");

if (!isset($_SESSION['curCart'])) header("Location: GosselinGourmetGoods.php");
$Cart = unserialize($_SESSION['curCart']);
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>Checkout</title>
<link rel="stylesheet" href="GosselinGourmetGoods.css" type="text/css" />
</head>
<body>
<div class="welcome-container">
    <h1>✅ Checkout</h1>
    
    <div class="category-section">
        <?php
        $orderID = $Cart->checkout();
        $sessionID = session_id();
        ?>
        
        <h2 style="color: #5D3A1A; text-align: center;">🎉 Order Confirmation</h2>
        
        <div style="background-color: rgba(139, 69, 19, 0.1); padding: 20px; border-radius: 10px; margin: 20px 0; text-align: center;">
            <p style="font-size: 1.3em;"><strong>Order #<?php echo $orderID; ?></strong></p>
            <p>Session ID: <code style="background-color: #f5f5f5; padding: 5px; border-radius: 3px;"><?php echo $sessionID; ?></code></p>
            <p style="color: #5D3A1A; font-style: italic;">Thank you for your order!</p>
        </div>
        
        <?php
        $_SESSION['curCart'] = serialize($Cart);
        ?>
    </div>
    
    <p style="text-align: center; margin-top: 30px;">
        <a href="ViewOrders.php?PHPSESSID=<?php echo session_id(); ?>">📋 View All My Orders</a> | 
        <a href="GosselinGourmetGoods.php">🏠 Return to Home</a>
    </p>
    
    <div class="footer">
        <p>Your order has been successfully recorded and is being processed</p>
    </div>
</div>
</body>
</html>
