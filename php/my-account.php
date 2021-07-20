<?php
    error_reporting(0);
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


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="../css/my-account.css">
    <title> My Account </title>
    <!-- Favicon -->
    <link rel="shortcut icon" href="../image/icons/favicon.png" type="image/x-icon" />
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
              <a id="profile" class="user-profile"> <img src="../image//user-profile/<?=$userSelectedRow['PROFILEPIC']?>"></a>
         </nav>
    </div>
    <div class="sub-header">
        <ul>
            <li><a href="index.php" class="page"> Home </a> </li>
            <li><a href="../php/all-product.php"> Products</a>  </li>
            <li><a href="../E-commerce/blogs.php"> Blogs </a>  </li>

        </ul>
    </div>




    <div class="dropdown-nav" id="dropdown-nav" style="display: none">
      <!--<a href="#">My Account</a>
      <a href="#">Order History</a>-->
      <a href="./processes/logout.php">Logout</a>
    </div>
</header>
<!-- HEADER - END -->


<!--MY ACCOUNT -->

<div class="my-account-container">

    <div class="change-container">
        <div class="profile-container">
            <div class="profile-pic">
                <img src="../image/user-profile/iska.jpg" alt="">
            </div>
            <div class="button-change-profile">
                <input type="file" name="image" id="image"><br>
                <input type="submit" value="Change profile">
            </div>
            <div class="order-history-container">
                <a href=""> Order History </a>
            </div>
        </div>
        <div class="user-details">
            <table border="0">
                <tr> 
                    <td> Firstname: </td>
                    <td> <input type="text" name="fname" id=""> </td>
                    
                </tr>
                <tr>
                    <td> Lastname: </td>
                    <td> <input type="text" name="lname" id=""> </td>
                </tr>
                <tr> 
                    <td> Address: </td>
                    <td colspan="2"> <input type="text" name="address" id=""></td>
                </tr>
                <tr> 
                    <td> Zip: </td>
                    <td> <input type="text" name="fname" id=""></td>
                </tr>
                <tr> 
                    <td> Email: </td>
                    <td> <input type="text" name="fname" id=""></td>
                </tr>
            </table>

            <table border="0" class="">
                <tr> 
                    <td> Old password: </td>
                    <td> <input type="text" name="fname" id=""> </td>
                    
                </tr>
                <tr>
                    <td> New password: </td>
                    <td> <input type="text" name="lname" id=""> </td>
                </tr>
                <tr> 
                    <td> Re-type password: </td>
                    <td colspan="2"> <input type="text" name="address" id=""></td>
                </tr>
                <tr>
                    <td colspan="2"> <input type="submit" value="Change"> </td>
                </tr>
            </table>


        </div>
    </div>
</div>


</body>
</html>