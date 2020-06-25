<?php
// Include config file
require_once "config.php";
 
// Define variables and initialize with empty values
$bookname= $author = $bookcategory = $image = "";

$price =1;
$bookname_err = $author_err = $price_err = $bookcategory_err = $image_err = "";
 
// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
 
    // Validate bookname
    if(empty(trim($_POST["bookname"]))){
        $bookname_err = "Please enter a bookname.";
    } else{
        // Prepare a select statement
        $sql = "SELECT bookname FROM book WHERE bookname = :bookname";
        
        if($stmt = $pdo->prepare($sql)){
            // Bind variables to the prepared statement as parameters
            $stmt->bindParam(":bookname", $param_bookname, PDO::PARAM_STR);
            
            // Set parameters
            $param_bookname = trim($_POST["bookname"]);
            
            // Attempt to execute the prepared statement
            if($stmt->execute()){
                if($stmt->rowCount() == 1){
                    $bookname_err = "This bookname is already added.";
                } else{
                    $bookname = trim($_POST["bookname"]);
                }
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }

            // Close statement
            unset($stmt);
        }
    }
    
    // Validate author
    if(empty(trim($_POST["author"]))){
        $author_err = "Please enter a author.";     
    }else{
        $sql = "SELECT id FROM author WHERE name = :name";
        if($stmt = $pdo->prepare($sql)){
            // Bind variables to the prepared statement as parameters
            $stmt->bindParam(":name", $param_author, PDO::PARAM_STR);
            
            // Set parameters
            $param_author = trim($_POST["author"]);
            
            // Attempt to execute the prepared statement
            if($stmt->execute()){
                if($stmt->rowCount() == 1){
                    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
                    $author = $result[0]['id'];
                    
                } else{
                    $author_err = "This author is not in database.";
                    
                }
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }

            // Close statement
            unset($stmt);
        }
    }
    
    // Validate confirm price
    if(empty(trim($_POST["price"]))){
        $price_err = "Please add price.";     
    }else{
        $price = $_POST["price"];
    }

    // Validate confirm category
    if(empty(trim($_POST["bookcategory"]))){
        $bookcategory_err = "Please add book category.";     
    }else{
               // Prepare a select statement
               $sql = "SELECT id FROM bookcategory WHERE name = :name";
        
               if($stmt = $pdo->prepare($sql)){
                   // Bind variables to the prepared statement as parameters
                   $stmt->bindParam(":name", $param_categoryname, PDO::PARAM_STR);
                   
                   // Set parameters
                   $param_categoryname = trim($_POST["bookcategory"]);
                   
                   // Attempt to execute the prepared statement
                   if($stmt->execute()){
                       if($stmt->rowCount() == 1){
                            
                            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
                            $bookcategory = $result[0]['id'];
                       } else{
                            $bookcategory_err = "This category is not in  database.";
                           
                       }
                   } else{
                       echo "Oops! Something went wrong. Please try again later.";
                   }
       
                   // Close statement
                   unset($stmt);
               }
    }

    if(empty(trim($_POST["image"]))){
        $image_err = "Please enter a image path.";     
    }else{
        $image = trim($_POST["image"]);
    }
    
    // Check input errors before inserting in database
    if(empty($bookname_err) && empty($author_err) && empty($price_err)){
        
        // Prepare an insert statement
        $sql = "INSERT INTO book (bookname, price, authorid, categoryid, image ) VALUES (:bookname, :price, :authorid, :categoryid, :image)";
         
        if($stmt = $pdo->prepare($sql)){
            // Bind variables to the prepared statement as parameters
            $stmt->bindParam(":bookname", $param_bookname, PDO::PARAM_STR);
            $stmt->bindParam(":price", $param_price, PDO::PARAM_INT);
            $stmt->bindParam(":authorid", $param_authorid, PDO::PARAM_INT);
            $stmt->bindParam(":categoryid", $param_categoryid, PDO::PARAM_INT);
            $stmt->bindParam(":image", $param_image, PDO::PARAM_STR);
            
            
            // Set parameters
            $param_bookname = $bookname;
            $param_price = $price;
            $param_authorid = $author;
            $param_categoryid = $bookcategory;
            $param_image = $image;
            

            
            
            // Attempt to execute the prepared statement
            if($stmt->execute()){
                // Redirect to login page
                header("location: admin.php");
            } else{
                echo "Something went wrong. Please try again later.";
            }

            // Close statement
            unset($stmt);
        }
    }
    
    // Close connection
    unset($pdo);
}
?>
 
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">
    <style type="text/css">
        body{ font: 14px sans-serif; }
        .wrapper{ width: 350px; padding: 20px; }
    </style>
</head>
<body>
    <div class="wrapper">
        <h2>Administration</h2>
        <p>Please fill this form to add book.</p>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <div class="form-group <?php echo (!empty($bookname_err)) ? 'has-error' : ''; ?>">
                <label>Book Name</label>
                <input type="text" name="bookname" class="form-control" value="<?php echo $bookname; ?>">
                <span class="help-block"><?php echo $bookname_err; ?></span>
            </div>    
            <div class="form-group <?php echo (!empty($author_err)) ? 'has-error' : ''; ?>">
                <label>Author</label>
                <input type="text" name="author" class="form-control" value="<?php echo $author; ?>">
                <span class="help-block"><?php echo $author_err; ?></span>
            </div>
            <div class="form-group <?php echo (!empty($price_err)) ? 'has-error' : ''; ?>">
                <label>Price</label>
                <input type="number" name="price" class="form-control" value="<?php echo $price; ?>">
                <span class="help-block"><?php echo $price_err; ?></span>
            </div>
            <div class="form-group <?php echo (!empty($bookcategory_err)) ? 'has-error' : ''; ?>">
                <label>Category</label>
                <input type="text" name="bookcategory" class="form-control" value="<?php echo $bookcategory; ?>">
                <span class="help-block"><?php echo $bookcategory_err; ?></span>
            </div>
            <div class="form-group <?php echo (!empty($bookcategory_err)) ? 'has-error' : ''; ?>">
                <label>Image location</label>
                <input type="text" name="image" class="form-control" value="<?php echo $image; ?>">
                <span class="help-block"><?php echo $image_err; ?></span>
            </div>
            <div class="form-group">
                <input type="submit" class="btn btn-primary" value="Add Book">
                <input type="reset" class="btn btn-default" value="Reset Form">
            </div>
         
        </form>
    </div>
        
</body>
</html>