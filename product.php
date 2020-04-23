<!-- This file will display a product (depends on the GET request) and will contain a form that will
 allow the user to change the quantity and add to cart the product. -->

<?php 
    //Check the make sure  the id parameter is specified in the URL
    if(isset($_GET['id']))
    {
        //Prepare statement and execute, prevents SQL injection
        $stmt = $pdo->prepare('SELECT * FROM products WHERE id = ?');
        $stmt->execute([$_GET['id']]);
        //Fetch  the product from the database and return  the result as an Array
        $product = $stmt->fetch(PDO::FETCH_ASSOC);
        //Check if
    }
?>