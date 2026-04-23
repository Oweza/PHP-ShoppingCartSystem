<?php
session_start();
$_SESSION = array();
session_destroy();
session_start();
require_once("ShoppingCart.php");
$Cart = new ShoppingCart();
$_SESSION['curCart'] = serialize($Cart);
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>Gosselin Gourmet Goods - Home</title>
<link rel="stylesheet" href="GosselinGourmetGoods.css" type="text/css" />
</head>
<body>
<div class="welcome-container">
    <h1>Welcome to Gosselin Gourmet Goods</h1>
    
    <div class="category-section">
        <h3>🛍️ Shop by Category:</h3>
        <p>
            <a href="GosselinGourmetCoffees.php?PHPSESSID=<?php echo session_id(); ?>">☕ Gourmet Coffees</a><br>
            <a href="GosselinGourmetAntiques.php?PHPSESSID=<?php echo session_id(); ?>">🪑 Old Tyme Antiques</a><br>
            <a href="GosselinGourmetBoutique.php?PHPSESSID=<?php echo session_id(); ?>">💻 Electronics Boutique</a>
        </p>
    </div>
    
    <div class="category-section">
        <h3>📦 Order History:</h3>
        <p>
            <a href="ViewOrders.php?PHPSESSID=<?php echo session_id(); ?>">📋 View All My Orders</a>
        </p>
    </div>
    
    <div class="footer">
        <p>Discover the finest gourmet products, timeless antiques, and cutting-edge electronics</p>
    </div>
</div>
</body>
</html>