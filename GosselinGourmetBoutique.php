<?php
session_start();
require_once("ShoppingCart.php");

$Cart = isset($_SESSION['curCart']) ? unserialize($_SESSION['curCart']) : new ShoppingCart();
$Cart->storeID = "ELECBOUT";
$Cart->setTable("inventory");
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>Electronics Boutique</title>
<link rel="stylesheet" href="ElectronicsBoutique.css" type="text/css" />
</head>
<body>
<h1>Electronics Boutique</h1>
<p>Computer accessories and peripheral devices</p>
<?php
$Cart->getProductList();
$_SESSION['curCart'] = serialize($Cart);
?>
<p><a href='<?php echo "ShowCart.php?PHPSESSID=" . session_id() ?>'>Show Shopping Cart</a></p>
<p><a href="GosselinGourmetGoods.php">Return to Home</a></p>
</body>
</html>