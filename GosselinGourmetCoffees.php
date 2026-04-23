<?php
session_start();
require_once("ShoppingCart.php");

$Cart = isset($_SESSION['curCart']) ? unserialize($_SESSION['curCart']) : new ShoppingCart();
$Cart->storeID = "COFFEE";
$Cart->setTable("inventory");
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>Gosselin Gourmet Coffees</title>
<link rel="stylesheet" href="GosselinGourmet.css" type="text/css" />
</head>
<body>
<h1>Gosselin Gourmet Coffees</h1>
<p>Specialty coffees made from the world's finest beans</p>
<?php
$Cart->getProductList();
$_SESSION['curCart'] = serialize($Cart);
?>
<p><a href='<?php echo "ShowCart.php?PHPSESSID=" . session_id() ?>'>Show Shopping Cart</a></p>
<p><a href="GosselinGourmetGoods.php">Return to Home</a></p>
</body>
</html>
