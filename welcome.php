<?php
// Initialize the session
session_start();
 
// Check if the user is logged in, if not then redirect him to login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: login.php");
    exit;
}


require_once 'config.php';

$status="";
if (isset($_POST['book']) && $_POST['book']!=""){
$book = $_POST['book'];
$book = preg_replace('/(?<!\ )[A-Z]/', ' $0', $book);
$book = ltrim($book);



$result = $pdo->prepare("SELECT * FROM `book` WHERE `bookname`='$book'");
$result->execute();
$result = $result->fetchAll(PDO::FETCH_ASSOC);
$name = $result[0]['bookname'];
$price = $result[0]['price'];
$image = $result[0]['image'];

$cartArray = array(
	$book=>array(
	'bookname'=>$name,
	'price'=>$price,	
	'quantity'=>1,
	'image'=>$image)
);


if(empty($_SESSION["shopping_cart"])) {
	$_SESSION["shopping_cart"] = $cartArray;
	$status = "<div class='box'>Product is added to your cart!</div>";
}else{
	$array_keys = array_keys($_SESSION["shopping_cart"]);
	if(in_array($book,$array_keys)) {
		$status = "<div class='box' style='color:red;'>
		Product is already added to your cart!</div>";	
	} else {
	$_SESSION["shopping_cart"] = array_merge($_SESSION["shopping_cart"],$cartArray);
	$status = "<div class='box'>Product is added to your cart!</div>";
	}

	}
}


?>
 
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Welcome</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">
    <link rel='stylesheet' href='style.css' type='text/css' media='all' />
    <style type="text/css">
        body{ font: 14px sans-serif; text-align: center; }
    </style>
</head>
<body>

    <div class="page-header">
        <h1>Hi, <b><?php echo htmlspecialchars($_SESSION["username"]); ?></b>. Welcome to our bookstore.</h1>
    </div>

    
<?php
if(!empty($_SESSION["shopping_cart"])) {
$cart_count = count(array_keys($_SESSION["shopping_cart"]));
?>

<div class="cart_div">
	<a href="cart.php"> <img src="shopping-cart-icon.png"/> Cart<span> <?php echo $cart_count; ?> </span> </a>
</div>

<?php
}
require_once "config.php";

$stmt = $pdo->prepare("SELECT * FROM book");
    $stmt->execute();
    $books = $stmt->fetchAll();

    foreach ($books as $row) {
        # code...
        $id = $row['authorid'];
        $stmt2 = $pdo->prepare("SELECT name FROM author where id = $id");
            $stmt2->execute();
			$author = $stmt2->fetchAll(PDO::FETCH_ASSOC);
			$bookNameWithWhiteSpace = $row['bookname'];
			$bookNameWithoutWhiteSpace = str_replace(' ', '', $bookNameWithWhiteSpace);
        echo "<div class='product_wrapper'>
			  <form method='post' action=''>
			  <input type='hidden' name='book' value=".$bookNameWithoutWhiteSpace.' '."/>
			  <div class='image'><img src='".$row['image']."' /></div>
			  <div class='name'>".$row['bookname']."</div>
			  <div class='name'>".$author[0]['name']."</div>
		   	  <div class='price'>$".$row['price']."</div>
			  <button type='submit' class='buy'>Buy Now</button>
			  </form>
		   	  </div>";
        }

    

    
    

		
?>

<div style="clear:both;"></div>

<div class="message_box" style="margin:10px 0px;">
<?php echo $status; ?>
</div>




    <p>
        
        <a href="logout.php" class="btn btn-danger">Sign Out of Your Account</a>
		<a href="profile.php" class="btn btn-primary">Profile</a>
		<?php
		$user = htmlspecialchars($_SESSION['username']);
		$sql = "SELECT username from users where role = 1";
		foreach ($pdo->query($sql) as $row) {
			if($row['username'] == $_SESSION['username'] ){
				echo "<a href='admin.php' class='btn btn-success'>Admin</a>";
			}

		}
?>	
	
    </p>
	

	
</body>
</html>