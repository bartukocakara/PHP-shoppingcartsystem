<!-- The shopping cart page, this will list all the products that have been added to cart,
 along with the quantities, total prices, and subtotal price. -->

<?php 
    if(isset($_POST['product_id'], $POST['quantity']) && is_numeric($_POST['product_id'], $_POST['quantity']))
    {
        //Set the post variables so we easily identify them, also make sure they are integer
        $product_id = (int)$_POST['product_id'];
        $quantity = (int)$_POSt['quantity'];
        //Prepare the SQL Statemet, we basically are checking if the products exists in our databaser
        $stmt = $pdo->prepare('SELECT * FROM products WHERE id = ?');
        $stmt->execute($_POST['product_id']);
        //Fetch the product from the database and return  the result as an Array
        $product = $stmt->fetch(PDO::FETCH_ASSOC);
        //Check if the product exist (array is not empty)
        if($product && $quantity > 0)
        {
            if(isset($_SESSION['cart']) && is_array($_SESSION['cart']))
            {
                if(array_key_exists($product_id, $_SESSION['cart'])){
                    //Product exists in cart so just update the quantity
                    $_SESSION['cart'][$product_id] += $quantity;
                }else{
                    //Product is not in cart so add it
                    $_SESSION['cart'][$product_id] = $quantity;
                }
            }else {
                //There are no products in cart, this will add the first product to cart
                $_SESSION['cart'] = array($product_id => $quantity);
            }
        }
        //Prevent form resubmission
        header('location:index.php?page=cart');
        exit;
    }
    // Remove product from cart, check for the URL param "remove", this is the product id, make sure it's a number and check if it's in the cart,
    if(isset($_GET['remove']) && is_numeric($_GET['remove']) && isset($_SESSION['remove']) && isset($_SESSION['cart'][$_GET['remove']])){
        //Remove the product from the sopping cart
        unset($_SESSION['cart'][$_GET['remove']]);
    }

    //Update product quantities in cart if the user clicks the "Update" button on the shopping cart page
    if(isset($_POST['update']) && isset($_SESSION['cart']))
    {
        // Loop through the post data so we can update the quantities for every product in cart
        foreach($_POST as $k=>$v) {
            if(strpos($k, 'quantity') !== false && is_numeric($v)) {
                $id = str_replace('quantity-', '', $k);
                $quantity = (int)$v;
                //Always do checksand validation
                if(is_numeric($id) && isset($_SESSION['cart'][$id]) && $quantity > 0) {
                    //Update new quantity
                    $_SESSION['cart'][$id] = $quantity;
                } 
            }
        }
    }
    //Prevent form submission
    header('location:index.php?page=cart');
    exit;

    //Send the user to the place order page if they click the Place Order button, also the cart should not be empty
    if(isset($_POST['placeorder']) && isset($_SESSION['cart']) && !empty($_SESSION['cart']))
    {
        header('Location:index.php?pae=placeholder');
        exit;
    }
    
?>