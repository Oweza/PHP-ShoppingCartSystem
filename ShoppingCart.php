<?php
// ShoppingCart.php
class ShoppingCart {
    public $DBConnect;
    public $DBName = "gosselin";
    public $Orders = array();         // productID => quantity
    public $OrderTable = array();     // productID => table name (store)
    public $TableName = "";
    public $storeID = "";

    // constructor
    public function __construct() {
        include_once("inc_OnlineStoreDB.php");
        global $DBConnect;
        $this->DBConnect = $DBConnect;
    }

    // reconnect when unserializing
    public function __wakeup() {
        $DB_HOST = "localhost";
        $DB_USER = "root";
        $DB_PASS = "";
        $DB_NAME = "gosselin";

        $this->DBConnect = new mysqli($DB_HOST, $DB_USER, $DB_PASS, $DB_NAME);

        if ($this->DBConnect->connect_errno) {
            die("<p>Database connection failed: " . $this->DBConnect->connect_error . "</p>");
        }
    }

    // optional __sleep() - choose what to serialize
    public function __sleep() {
        return array("Orders", "OrderTable", "storeID", "TableName");
    }

    // set active store / table
    public function setTable($table) {
        $this->TableName = $table;
    }

    // list products for a given table
    public function getProductList() {
        $SQLstring = "SELECT * FROM inventory WHERE storeID='" . $this->DBConnect->real_escape_string($this->storeID) . "'";
        $QueryResult = @$this->DBConnect->query($SQLstring)
            or die("<p>Unable to perform query.</p>");

        echo "<table width='100%' border='1'>";
        echo "<tr><th>Product</th><th>Description</th><th>Price Each</th><th>Select Item</th></tr>";

        while ($Row = $QueryResult->fetch_assoc()) {
            echo "<tr>";
            echo "<td>{$Row['name']}</td>";
            echo "<td>{$Row['description']}</td>";
            printf("<td align='center'>R%.2f</td>", $Row['price']);
            echo "<td align='center'><a href='ShowCart.php?PHPSESSID=" . session_id() .
                 "&operation=addItem&productID=" . $Row['productID'] . 
                 "&tableName=" . $this->TableName . "'>Add</a></td>";
            echo "</tr>";
        }
        echo "</table>";
    }

    // add new item
    public function addItem() {
        $ProdID = $_GET['productID'];
        if (array_key_exists($ProdID, $this->Orders))
            exit("<p>You already selected that item! Click your browser's back button.</p>");
        $this->Orders[$ProdID] = 1;
        $this->OrderTable[$ProdID] = $_GET['tableName'];
    }

    // add one more
    public function addOne() {
        $ProdID = $_GET['productID'];
        if (array_key_exists($ProdID, $this->Orders))
            $this->Orders[$ProdID]++;
    }

    // remove one
    public function removeOne() {
        $ProdID = $_GET['productID'];
        if (array_key_exists($ProdID, $this->Orders)) {
            $this->Orders[$ProdID]--;
            if ($this->Orders[$ProdID] <= 0)
                unset($this->Orders[$ProdID]);
        }
    }

    // remove item entirely
    public function removeItem() {
        $ProdID = $_GET['productID'];
        if (array_key_exists($ProdID, $this->Orders))
            unset($this->Orders[$ProdID]);
    }

    // empty the entire cart
    public function emptyCart() {
        $this->Orders = array();
        $this->OrderTable = array();
    }

    // showCart function
    public function showCart() {
        if (empty($this->Orders)) {
            echo "<p>Your shopping cart is empty!</p>";
            return;
        }

        echo "<table width='100%' border='1'>";
        echo "<tr><th>Remove Item</th><th>Product</th><th>Quantity</th><th>Price Each</th></tr>";

        $Total = 0;
        foreach ($this->Orders as $ProdID => $Qty) {
            $TableName = $this->OrderTable[$ProdID];
            $SQLstring = "SELECT * FROM inventory WHERE productID='" . $this->DBConnect->real_escape_string($ProdID) . "'";
            $QueryResult = @$this->DBConnect->query($SQLstring)
                or die("<p>Unable to perform query.</p>");
            $Row = $QueryResult->fetch_assoc();

            echo "<tr>";
            echo "<td align='center'><a href='ShowCart.php?PHPSESSID=" . session_id() .
                 "&operation=removeItem&productID=" . $Row['productID'] . "'>Remove</a></td>";
            echo "<td>{$Row['name']}</td>";
            echo "<td align='center'>$Qty 
                  <a href='ShowCart.php?PHPSESSID=" . session_id() .
                 "&operation=addOne&productID=" . $Row['productID'] . "'>+</a>
                  <a href='ShowCart.php?PHPSESSID=" . session_id() .
                 "&operation=removeOne&productID=" . $Row['productID'] . "'>-</a></td>";
            printf("<td align='center'>R%.2f</td></tr>", $Row['price']);
            $Total += $Row['price'] * $Qty;
        }

        echo "<tr><td align='center'><a href='ShowCart.php?PHPSESSID=" . session_id() .
             "&operation=emptyCart'><strong>Empty Cart</strong></a></td>";
        echo "<td colspan='2' align='center'><strong>Total Items: " . count($this->Orders) . "</strong></td>";
        printf("<td align='center'><strong>Total: R%.2f</strong></td></tr>", $Total);
        echo "</table>";
    }

    // checkout - now returns orderID
    public function checkout() {
        // Create new order record
        $SQLorder = "INSERT INTO orders (clientID) VALUES ('guest')";
        $this->DBConnect->query($SQLorder);
        $orderID = $this->DBConnect->insert_id; // auto-generated order ID

        // Insert products into orders_inventory
        foreach ($this->Orders as $ProdID => $Qty) {
            $SQLitems = "INSERT INTO orders_inventory (orderID, productID, quantity)
                         VALUES ($orderID, '$ProdID', $Qty)";
            $this->DBConnect->query($SQLitems);
        }

        $this->emptyCart();
        return $orderID; // Return the order ID
    }

}
?>
