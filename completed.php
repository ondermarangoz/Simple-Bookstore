<?php
session_start();

unset($_SESSION['cartArray']);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" rel="stylesheet"/>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    
    
</head>
<body>
<div class="col-12 border border-info">
          <div class="d-flex justify-content-center align-items-center" style="height: 100px">
                <p><b>Checkout is made successfully.</b></p>
                 <br><br>
              <a href="welcome.php" class="btn btn-dark">Home Page</a>
              <a href="logout.php" class="btn btn-dark mr-2 ml-2">Logout</a>
              
          </div>
    </div>
</body>
</html>