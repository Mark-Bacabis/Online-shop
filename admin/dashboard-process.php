<?php
    include "../connection.php";

    if(isset($_POST['add-btn'])){
        $picture = $_FILES['picture'];
        $pname = $_POST['pname'];
        $price = $_POST['price'];
        $stocks = $_POST['stocks'];
        $type = $_POST['type'];
        $brand = $_POST['brand'];

        $picture_name = $_FILES['picture']['name'];
        $picture_tmpName = $_FILES['picture']['tmp_name'];
        $picture_error = $_FILES['picture']['error'];
        $picture_size = $_FILES['picture']['size'];

        if($picture_error === 0){

            $pic_ext = pathinfo($picture_name, PATHINFO_EXTENSION);

            $pic_ext_lc = strtolower($pic_ext);

            $allowed_ext = array("jpg","jpeg", "png");

            if(in_array($pic_ext_lc, $allowed_ext)){
                $new_pic_name = uniqid("product-").'.'.$pic_ext_lc;

                $pic_path = "../Products/".$new_pic_name;

                
            
            // COUNT 
            $cnt = oci_parse($connection, "SELECT COUNT(*) AS TOTAL FROM PRODUCTS");
            oci_execute($cnt);

            $cntP = oci_fetch_assoc($cnt);

            $pid = $cntP['TOTAL'] + 1;
                

            //INSERT INTO PRODUCTS 
            $ins = oci_parse($connection, "INSERT INTO PRODUCTS 
            (PRODUCTID, PRODUCTNAME, PRODUCTPRICE, PICTURE, STOCKS, TYPE, BRAND) 
            VALUES 
            ($pid, '$pname', $price, '$new_pic_name', $stocks, '$type', '$brand')");

                if($ins){
                   
                    oci_execute($ins);
                    move_uploaded_file($picture_tmpName, $pic_path);
                    header("location:dashboard.php?Success");
                }
                else{
                    echo oci_error($connection);
                }
            }

        }
    }


    if(isset($_POST['edit-btn'])){
        $id = $_POST['id'];
        $price = $_POST['price'];
        $stocks = $_POST['stocks'];
       
        // UPDATE
        $upd = oci_parse($connection, "UPDATE PRODUCTS SET PRODUCTPRICE = $price, STOCKS = $stocks WHERE PRODUCTID = $id");
        oci_execute($upd);

        if(!$upd){
           echo oci_error($upd);
        }
        else{
            header("location:dashboard.php?query=success");
        }
    }

?>