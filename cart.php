<?php

session_start();
$status="";
if (isset($_POST['action']) && $_POST['action']=="remove"){
if(!empty($_SESSION["shopping_cart"])) {
	foreach($_SESSION["shopping_cart"] as $key => $value) {
		if($_POST["bookname"] == $key){
		unset($_SESSION["shopping_cart"][$key]);
		$status = "<div class='box' style='color:red;'>
		Product is removed from your cart!</div>";
		}
		if(empty($_SESSION["shopping_cart"]))
		unset($_SESSION["shopping_cart"]);
			}		
		}
}

if (isset($_POST['action']) && $_POST['action']=="change"){
  foreach($_SESSION["shopping_cart"] as &$value){
    if($value['bookname'] === $_POST["bookname"]){
        $value['quantity'] = $_POST["quantity"];
        break; // Stop the loop after we've found the product
    }
}
  	
}
?>
<html>
<head>
<title>Cart</title>
<link rel='stylesheet' href='style.css' type='text/css' media='all' />
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">
</head>
<body>
<div style="width:700px; margin:50 auto;">

<h2>Shopping Cart</h2>   

<?php
if(!empty($_SESSION["shopping_cart"])) {
$cart_count = count(array_keys($_SESSION["shopping_cart"]));
?>
<div class="cart_div">
<a href="cart.php">
<img src="shopping-cart-icon.png" width="20px"  /> Cart
<span><?php echo $cart_count; ?></span></a>
</div>
<?php
}
?>

<div class="cart">
<?php
if(isset($_SESSION["shopping_cart"])){
    $total_price = 0;
?>	
<table class="table">
<tbody>
<tr>
<td></td>
<td><b>ITEM NAME</b></td>
<td><b>QUANTITY</b></td>
<td> <b> UNIT PRICE </b></td>
<td> <b> ITEMS TOTAL </b></td>
</tr>	
<?php		
foreach ($_SESSION["shopping_cart"] as $book){
?>
<tr>
<td><img src='<?php echo $book["image"]; ?>' width="40" height="100" /></td>
<td><?php echo $book["bookname"]; ?><br />
<form method='post' action=''>
<input type='hidden' name='bookname' value="<?php echo $book["bookname"]; ?>" />
<input type='hidden' name='action' value="remove" />
<button type='submit' class='remove'>Remove Book</button>
</form>
</td>
<td>
<form method='post' action=''>
<input type='hidden' name='bookname' value="<?php echo $book["bookname"]; ?>" />
<input type='hidden' name='action' value="change" />
<select name='quantity' class='quantity' onchange="this.form.submit()">
<option <?php if($book["quantity"]==1) echo "selected";?> value="1">1</option>
<option <?php if($book["quantity"]==2) echo "selected";?> value="2">2</option>
<option <?php if($book["quantity"]==3) echo "selected";?> value="3">3</option>
<option <?php if($book["quantity"]==4) echo "selected";?> value="4">4</option>
<option <?php if($book["quantity"]==5) echo "selected";?> value="5">5</option>
</select>
</form>
</td>
<td><?php echo "$".$book["price"]; ?></td>
<td><?php echo "$".$book["price"]*$book["quantity"]; ?></td>
</tr>
<?php
$total_price += ($book["price"]*$book["quantity"]);
}
?>
<tr>
<td colspan="5" align="right">
<strong>TOTAL: <?php echo "$".$total_price; ?></strong>
<br>
<a href="checkout.php" class="btn btn-success">BUY</a>	
</td>
</tr>
</tbody>
</table>
	
  <?php
}else{
	echo "<h3>Your cart is empty!</h3>";
	}
?>
</div>

<div style="clear:both;"></div>

<div class="message_box" style="margin:10px 0px;">
<?php echo $status; ?>
</div>


<br /><br />

</div>
</body>
</html>