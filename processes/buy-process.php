<?php

    session_start();
    include "../connection.php";


    if(isset($_POST['buy-btn'])){
    
        
        $userID = $_SESSION['userID'];
        $prod = $_SESSION['prodID'];

        if(empty($userID)){
            header("location:../E-commerce/login.php");
        }
        else{
             // CART COUNT
            $countItem = oci_parse($connection, "SELECT COUNT(*) AS TOTAL FROM CART_TBL");
            oci_execute($countItem);

            $itemCount = oci_fetch_assoc($countItem);

            $cartID = $itemCount['TOTAL'] + 1;
            
            $quantity = $_POST['qty'];

            $ins = "INSERT INTO CART_TBL (CARTID, CUSTOMERID, PRODUCTID, QTY) VALUES ($cartID, $userID, $prod, $quantity)";

            $insert = oci_parse($connection, $ins);

            if(!$insert){
                echo oci_error($connection);
            }
            else{
                oci_execute($insert);
                header("location:../php/cart.php?id=$cartID");
            }

        }

       
    }
?>