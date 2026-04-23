<?php
session_start();
require_once("ShoppingCart.php");
if (!isset($_SESSION['curCart'])) header("Location: GosselinGourmetGoods.php");

$Cart = unserialize($_SESSION['curCart']);

if (isset($_GET['operation'])) {
    switch ($_GET['operation']) {
        case "addItem": $Cart->addItem(); break;
        case "removeItem": $Cart->removeItem(); break;
        case "addOne": $Cart->addOne(); break;
        case "removeOne": $Cart->removeOne(); break;
        case "emptyCart": $Cart->emptyCart(); break;
    }
}
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>Shopping Cart</title>
<link rel="stylesheet" href="GosselinGourmetGoods.css" type="text/css" />
</head>
<body>
<div class="welcome-container">
    <h1>🛒 Your Shopping Cart</h1>
    
    <div class="category-section">
        <?php
        $Cart->showCart();
        $_SESSION['curCart'] = serialize($Cart);
        ?>
    </div>
    
    <p style="text-align: center; margin-top: 30px;">
        <a href="Checkout.php?PHPSESSID=<?php echo session_id(); ?>&operation=checkout">✅ Checkout</a> | 
        <a href="ViewOrders.php?PHPSESSID=<?php echo session_id(); ?>">📋 View All My Orders</a> | 
        <a href="GosselinGourmetGoods.php">❌ Cancel Order / Return to Home</a>
    </p>
    
    <div class="footer">
        <p><a href="GosselinGourmetCoffees.php?PHPSESSID=<?php echo session_id(); ?>">Continue Shopping - Coffees</a> | 
           <a href="GosselinGourmetAntiques.php?PHPSESSID=<?php echo session_id(); ?>">Antiques</a> | 
           <a href="GosselinGourmetBoutique.php?PHPSESSID=<?php echo session_id(); ?>">Electronics</a></p>
    </div>
</div>
</body>
</html>