<?php
session_start();
require_once("ShoppingCart.php");

$Cart = isset($_SESSION['curCart']) ? unserialize($_SESSION['curCart']) : new ShoppingCart();
$Cart->storeID = "ANTIQUE";
$Cart->setTable("inventory");
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>Old Tyme Antiques</title>
<link rel="stylesheet" href="OldTymeAntiques.css" type="text/css" />
</head>
<body>
<h1>Old Tyme Antiques</h1>
<p>Furniture from America's Colonial and Post-war periods</p>
<?php
$Cart->getProductList();
$_SESSION['curCart'] = serialize($Cart);
?>
<p><a href='<?php echo "ShowCart.php?PHPSESSID=" . session_id() ?>'>Show Shopping Cart</a></p>
<p><a href="GosselinGourmetGoods.php">Return to Home</a></p>
</body>
</html>
