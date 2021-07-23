<?php
    session_start();
    include "../connection.php";

    $userID = $_SESSION['userID'];

    // THIS IS A VARIABLE HANDLE FOR QUERY
    $qry = "select * from products order by PRODUCTID DESC FETCH FIRST 8 ROWS ONLY";

    // OCI_PARSE FOR CONNECTION DB AND QUERY 
    $result = oci_parse($connection, $qry);
    // OCI_EXECUTE WILL EXECUTE THE $result OR YOUR QUERY
    oci_execute($result); 


    // SELECT CUSTOMER
    $selectUser = oci_parse($connection, "SELECT * FROM CUSTOMERACC WHERE USERID = $userID");
    oci_execute($selectUser);

    $userSelectedRow = oci_fetch_assoc($selectUser);


    // CART COUNT
    $countItem = oci_parse($connection, "SELECT COUNT(*) AS TOTAL FROM CART_TBL WHERE CUSTOMERID = $userID");
    oci_execute($countItem);

    $itemCount = oci_fetch_assoc($countItem);

    // TRANSACTION 
    $selecTrans = oci_parse($connection, "SELECT * FROM TRANSACTION a
    JOIN PRODUCTS b
    ON a.PRODUCTID = b.PRODUCTID
    WHERE CUSTOMERID = $userID");
    oci_execute($selecTrans);


?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="../css/my-purchase.css">
    <!-- Favicon -->
    <link rel="shortcut icon" href="../image/icons/favicon.png" type="image/x-icon" />
  
    <title> MY - PURCHASE | CLOTHING LINES </title>
</head>


<!-- USER LOGIN CONDITION -->
    <?php if(!empty($userID)) {?>
      <style>
          .user-nav{
            display: flex;
          }
          .secondary-nav{
            display: none;
          }
      </style>
    <?php } else{ ?>
      <style>
          .user-nav{
            display: none;
          }
          .secondary-nav{
            display: flex;
          }
      </style>
    <?php } ?>



<body>
    

<!-- HEADER -->
<header>
    <div class="primary-header">
        <a href="../index.php"><img class="logo" src="../image/logo/Logo.svg" alt="Team Payaman Logo"> </a>

         <div class="search-bar">
              <input type="search" id="search" name="search" placeholder="Search products here">
              <button class="search-icon"> Search </button>
         </div>

         <nav class="secondary-nav">
              <a href="../E-commerce/register.php" class="register-link">Register</a>
              <a href="../E-commerce/login.php" class="login-link">Login</a>
         </nav>
         <nav class="user-nav">
              <a href="../php/cart.php" class="cart-icon">
                  <div class="count-cart">
                      <?=$itemCount['TOTAL']?>
                  </div>
                 <img src="../image/icons/shopping-cart.png" alt="">
              </a>
              <a id="profile" class="user-profile"> <img src="../image/user-profile/<?=$userSelectedRow['PROFILEPIC']?>" alt=""></a>
         </nav>
    </div>
    <div class="sub-header">
        <ul>
            <li><a href="../index.php"> Home </a> </li>
            <li><a href="./all-product.php"> Products</a>  </li>
            <li><a href="../E-commerce/blogs.php"> Blogs </a>  </li>

        </ul>
    </div>




    <div class="dropdown-nav" id="dropdown-nav" style="display: none">
      <!--<a href="#">My Account</a>
      <a href="#">Order History</a>-->
      <a href="../processes/logout.php">Logout</a>
    </div>
</header>
<!-- HEADER - END -->


<main>
    <div class="purch-title">
          <h1> My Purchase History </h1>
    </div>
    
    <div class="my-history">
        <div class="label">
            
        </div>
        <?php while($transact = oci_fetch_assoc($selecTrans)) {?>
            <div class="history-box">
                <div class="prod-pic">
                    <img src="../products/<?=$transact['PICTURE']?>" alt="">
                </div>
                <div class="prod-info">
                    <h3> <?=$transact['PRODUCTNAME']?> </h3>
                    <p> <?=$transact['PRICE']?>.00  </p>
                    <h3> <?=$transact['T_ID']?>  </h3>
                    <p> <?=$transact['DATEOFPURCHASE']?>  </p>
                    <p> <?=$transact['DATEARRIVED']?>  </p>
                    <h2> &#8369;<?=$transact['PRICE']?>.00 </h2>
                </div>
            </div>
        <?php } ?>
    </div>

</main>



<footer>
   <div class="payment-footer">
            <h2> PAYMENT METHOD </h2>
            <img src="../image/icons/paypal.png" alt="PayPal">
   </div>
   <div class="footer-primary">
          <div class="footer-info">
              <h2> ABOUT US </h2>
              <ul>
                  <li> <a href="#"> About us</a> </li>
                  <li> <a href="../E-commerce/privacy.php"> Privacy Policy </a> </li>
                  <li> <a href="../E-commerce/terms.php"> Terms and Agreement </a> </li>
              </ul>
          </div>
          <div class="footer-info">
            <h2> CUSTOMER SERVICE </h2>
              <ul>
                  <li> <a href="#"> Help Centre </a> </li>
                  <li> <a href="#"> Return and Refund </a> </li>
              </ul>
          </div>
          <div class="footer-info">
            <h2> CONTACT US </h2>
              <ul>
                  <li> 
                      <a href="#">
                        <img src="../image/icons/gmail.png" alt=""> tpclothingline@gmail.com 
                      </a> 
                  </li>
                  <li> 
                      <a href="#">
                        <img src="../image/icons/phone-call (1).png" alt=""> 0912-345-6789 
                      </a>   
                  </li>
                
              </ul>
          </div>
   </div>
</footer>




    <!--SCRIPT-->
    <script src="../js/main.js"></script>
</body>
</html>