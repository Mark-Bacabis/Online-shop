
<?php 
    error_reporting(0);
    include "../connection.php";

    

    // CUSTOMER
    $sel = oci_parse($connection, "SELECT * FROM CUSTOMERACC");
    oci_execute($sel);

      // TRANSACTION
      $selT = oci_parse($connection, "SELECT * FROM TRANSACTION 
      JOIN PRODUCTS 
      ON TRANSACTION.PRODUCTID = PRODUCTS.PRODUCTID
      ORDER BY ID");

      oci_execute($selT);


    // PRODUCT
    $selP = oci_parse($connection, "SELECT * FROM PRODUCTS ORDER BY PRODUCTID");
    oci_execute($selP);

    $did = $_GET['did'];
    $pid = $_GET['pid'];
    $query = $_GET['query'];

    if(!empty($pid)){
        echo "<style> .admin-content { display: none } 
                        .product-container { display: block }
                        .product-modal{ display: flex} 
                    
        </style>";

        //SELECT

        $selProduct = oci_parse($connection, "SELECT * FROM PRODUCTS WHERE PRODUCTID = $pid");
        oci_execute($selProduct);

        $product = oci_fetch_assoc($selProduct);


        $id = $product['PRODUCTID'];
        $name = $product['PRODUCTNAME'];
        $price = $product['PRODUCTPRICE'];
        $stocks = $product['STOCKS'];

    }
    else{
        echo "<style> .admin-content { display: block } 
        .product-container { display: none }
        .product-modal{ display: none} 
        </style>";
    }


    if(!empty($did)){
        echo "
        <style> 
           .admin-content { display: none } 
           .product-container { display: block }          
       </style>";

        //DELETE 
        $del = oci_parse($connection, "DELETE FROM PRODUCTS WHERE PRODUCTID = $did");
        oci_execute($del);
        header("location:dashboard.php?query=deleted");
   }
   else{
       echo "
       <style> 
           .admin-content { display: block } 
           .product-container { display: none }
       </style>";
   }



   if($query == "deleted"){
        echo "
        <style> 
        .admin-content { display: none } 
        .product-container { display: block }          
    </style>";
   }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/dashboard.css">
    <title> Team Payaman | Dashboard </title>
    <!--Load the AJAX API-->
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>

    <!-- aJax jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    
</head>
<script type="text/javascript">

      // Load the Visualization API and the corechart package.
      google.charts.load('current', {'packages':['corechart']});

      // Set a callback to run when the Google Visualization API is loaded.
      google.charts.setOnLoadCallback(drawChart);

      // Callback that creates and populates a data table,
      // instantiates the pie chart, passes in the data and
      // draws it.
      function drawChart() {

        // Create the data table.
        var data = new google.visualization.DataTable();
        data.addColumn('string', 'Topping');
        data.addColumn('number', 'Slices');
        data.addRows([
          ['Giyang Clothing', 300],
          ['ViyLine', 100],
          ['Boss Apparel', 150],
          ['Cong Clothing', 175],
          ['WLKJN', 50]
        ]);

        // Set chart options
        var options = {'title':'Team Payaman Brands Ranking',
                       'width':420,
                       'height':260};

        // Instantiate and draw our chart, passing in some options.
        var chart = new google.visualization.PieChart(document.getElementById('chart_div'));
        chart.draw(data, options);
      }
    </script>

<body>

    <div class="admin-container">
        <div class="admin-panel">
            <div class="admin-header">
                <h2>Team Payaman</h2><br>
                
            </div>
        
           
           <div class="admin">
               <div class="admin-profile">
                    <img src="../image/user-profile/default-profile.jpg" alt="">
                    <p> Jessica Bulleque </p>
               </div>
                <hr>
                <ul>
                    <li style="background-color: rgba(0, 0, 0, 0.5);" class="dashboard">
                        <img src="../admin/icons/home.png" alt="">
                        <a href="../admin/dashboard.php"> Dashboard </a>
                    </li>
                    <li class="customer">
                        <img src="../admin/icons/customers.png" alt="">
                        <a> Customers </a>
                    </li>
                    
                    <li class="products">
                        <img src="../admin/icons/products.png" alt="">
                        <a> Products </a>
                    </li>
                    <li class="orders">
                        <img src="../admin/icons/orders.png" alt="">
                        <a> Orders </a>
                    </li>
                    
                        
                    </li>
                   
                </ul>
           </div>
           <div class="settings">
                <h3> Settings </h3>
                <ul>
                    <li>
                        <img src="../admin/icons/settings.png" alt="">
                        <a href="#"> Settings </a>
                        
                    </li>
                    <li>
                        <img src="../admin/icons/account.png" alt="">
                        <a href="#"> My Account </a>
                       
                    </li>
                </ul>
           </div>

           
           <div class="admin-footer">
               <p> &copysr; TEAM PAYAMAN &bullet; 2021 </p>
           </div>

        </div>


        <div class="content-container">

            <div class="admin-header">
                
                <div class="title">
                    <h1> DASHBOARD </h1>
                </div>
                <div class="logout">
                <a href="../index.php"><img src="../admin/icons/logout.png" alt=""></a>
                </div>

                

            </div>




            <!-- FOR SUMMARY DASHBOARD -->
            <div class="admin-content">
                
                <div class="content-summary">
                    <div class="summary-box booking">
                        
                        <div class="count-box">
                        <h1> 600 </h1>
                        </div>
                        <div class="label">
                            <h3> Customers </h3>
                        </div>
                    </div>
                    <div class="summary-box customer">
                        
                        <div class="count-box">
                        <h1>500 </h1>
                        </div>
                        <div class="label">
                            
                            <h3> Products</h3>
                        </div>
                    </div>
                    <div class="summary-box movie">
                        
                        <div class="count-box">
                            <h1> 800 </h1>
                        </div>
                        <div class="label">
                            
                            <h3> Orders </h3>
                        </div>
                    </div>
                    <div class="summary-box">
                        <div class="count-box">
                            <h1> 7 </h1>
                        </div>
                        <div class="label">
                            <h3> To Ship </h3>
                        </div>
                    </div>
                    <div class="summary-box">
                        <div class="count-box">
                            <h1> 7 </h1>
                        </div>
                        <div class="label">
                            <h3> Delivered </h3>
                        </div>
                    </div>
                </div>
                
                <div class="content-sales">
                    <div class="sales">
                        <h3> Transaction ID </h3>
                        <h3>Product</h3>
                        <h3>Status</h3>
                    </div>
                    <div class="sales user-feedbacks">
            
                        <!--Div that will hold the pie chart-->
                        <div id="chart_div"></div>
                        
                    </div>

                </div> 
            </div>




            <!-- CUSTOMER -->
            <div class="customer-container">
                 <h1 class="title"> Customer </h1>
                <table border="0">
                    <tr>
                        <th> ID </th>
                        <th> Fullname </th>
                        <th> Email </th>
                        <th> Address </th>
                    </tr>
                    <!-- SELECT ALL BY ROW -->
                    <?php while($customerRow = oci_fetch_assoc($sel)){ ?>
                        <tr>
                            <td> <?=$customerRow['USERID']?> </td>
                            <td> <?=$customerRow['FIRSTNAME']?> <?=$customerRow['LASTNAME']?> </td>
                            <td> <?=$customerRow['EMAIL']?> </td>
                            <td> <?=$customerRow['ADDRESS']?>, <?=$customerRow['ZIP']?> </td>
                            
                        </tr>
                    <?php } ?>


                </table>
            </div>

            <!-- MODAL FOR ADDING PRODUCTS -->
            <div class="add-product-modal">
                <form action="./dashboard-process.php" method="POST" enctype="multipart/form-data">
                    <label for="pname"> Product name </label>
                    <input type="text" name="pname" id="pname" required>

                    <label for="price"> Price </label>
                    <input type="text" name="price" id="price" required>

                    <label for="stocks"> Stocks </label>
                    <input type="text" name="stocks" id="stocks" required>

                    <label for="type"> Type </label>
                    <input type="text" name="type" id="type" required>

                    <label for="pic"> Picture </label>
                    <input type="file" name="picture" id="pic" required>

                    <label for="brand"> Brand </label>
                    <input type="text" name="brand" id="brand" required>

                    <input type="submit" name="add-btn" value="Add product">
                    <button type="button" id="close"> Close </button>
                </form>
            </div>


            <!-- EDIT MODAL -->
            <div class="product-modal">
                <form action="./dashboard-process.php" method="POST">
                
               
                    <input style="display:none;" type="text" name="id" id="type" value="<?=$id?>" required>

                    <label for="pname"> Product name </label>
                    <input type="text" name="pname" id="pname" value="<?=$name?>" required disabled>

                    <label for="price"> Price </label>
                    <input type="text" name="price" id="price" value="<?=$price?>" required>

                    <label for="stocks"> Stocks </label>
                    <input type="text" name="stocks" id="stocks" value="<?=$stocks?>" required>


                    <input type="submit" name="edit-btn" value="Update Product">
                    <a href="dashboard.php" class="close"> Close </a>
                </form>
            </div>

            <!-- PRODUCTS -->
            <div class="product-container">
                <div class="button-add">
                     <button id="add-btn"> Add product </button>
                 </div>
                 <h1 class="title"> Products </h1>
                
                <table border="0">
                    <tr>
                        <th> Product ID </th>
                        <th> Product Name </th>
                        <th> Product Price </th>
                        <th> Stocks </th>
                        <th> Type </th>
                        <th> Brand </th>
                        <th colspan="2"> Action </th>
                    </tr>
                    <?php while($prodRow = oci_fetch_assoc($selP)) {?>
                    <tr>
                        <td> <?=$prodRow['PRODUCTID']?> </td>
                        <td> <?=$prodRow['PRODUCTNAME']?> </td>
                        <td> <?=$prodRow['PRODUCTPRICE']?> </td>
                        <td> <?=$prodRow['STOCKS']?> </td>
                        <td> <?=$prodRow['TYPE']?></td>
                        <td><?=$prodRow['BRAND']?> </td>
                        <td> <a href="?pid=<?=$prodRow['PRODUCTID']?>" class="edit-link">Edit</a> </td>
                        <td> <a href="?did=<?=$prodRow['PRODUCTID']?>" class="del-link">Delete</a> </td>
                    </tr>
                    <?php } ?>
                   
                </table>
            </div>


            <!-- ORDERS -->
            <div class="orders-container">
                 <h1 class="title"> Orders</h1>
                <table border="0">
                    <tr>
                        <th> Transaction ID </th>
                        <th> Product ID </th>
                        <th> Customer ID </th>
                        <th> Product </th>
                        <th> Price </th>
                        <th> Quantity </th>
                        <th> Total Price </th>
                        <th> Date of Purchase </th>
                        <th> Date of Delivery </th>
                    </tr>
                <?php while($transRow = oci_fetch_assoc($selT)) {?>
                    <tr>
                        <th> <?=$transRow['T_ID']?> </th>
                        <th> <?=$transRow['PRODUCTID']?> </th>
                        <th> <?=$transRow['CUSTOMERID']?> </th>
                        <th> <?=$transRow['PRODUCTNAME']?> </th>
                        <th> <?=$transRow['PRICE']?> </th>
                        <th> <?=$transRow['QTY']?> </th>
                        <th> <?=$transRow['TOTAL']?> </th>
                        <th> <?=$transRow['DATEOFPURCHASE']?> </th>
                        <th> <?=$transRow['DATEARRIVED']?> </th>
                    </tr>
                <?php } ?>
                   
                </table>
            </div>


            <!-- SHIPMENT-->
            <div class="shipment-container">
                 <h1 class="title"> Shipment</h1>
                <table border="0">
                    <tr>
                        <th> Transaction ID </th>
                        <th> Courier ID </th>
                        <th> Product </th>
                        <th> Price </th>
                        <th> Quantity </th>
                        <th> Over all Price </th>
                        <th> Status </th>
                    </tr>
                   
                </table>
            </div>

            

        </div>
    </div>

            
            

<script src="../js/dashboard.js"></script>

<script>
    const modalAdd = document.querySelector('.add-product-modal');

    const close = document.getElementById('close');
    const btnAdd = document.getElementById('add-btn');

    close.addEventListener('click', () =>{
        modalAdd.style.display = 'none';
    });

    btnAdd.addEventListener('click', () =>{
        modalAdd.style.display = 'flex';
    });

</script>
</body>
</html>