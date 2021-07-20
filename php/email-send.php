<?php
    session_start();
    include "../connection.php";


    $tid =   $_SESSION['trans'];
    $dateTime = $_SESSION['dateTime'];
    $dateArrived = $_SESSION['arrival'];
    $userID = $_SESSION['userID'];

    echo $tid.' ', $dateTime, $dateArrived, $userID;

    // SELECT CUSTOMER
    $selectUser = oci_parse($connection, "SELECT * FROM CUSTOMERACC WHERE USERID = $userID");
    oci_execute($selectUser);
 
    $userSelectedRow = oci_fetch_assoc($selectUser);



    $selectTransac = oci_parse($connection, "SELECT * FROM TRANSACTION WHERE ID = $tid");
    oci_execute($selectTransac);
 
    $TransacSelectedRow = oci_fetch_assoc($selectTransac);
    

    $email_to = $userSelectedRow['EMAIL'];
    $subject = "TEAM PAYAMAN CLOTHING";
    $header = "From: Team Payaman Clothing";
    $message = "Hi ".$userSelectedRow['FIRSTNAME']." ".$userSelectedRow['LASTNAME']." Your Transaction ID is: ".$TransacSelectedRow['T_ID']."\n\rParcel Estimated Date Arrival ".$TransacSelectedRow['DATEARRIVED']."";



   if(mail($email_to, $subject, $message, $header)){
        header("location:/ONLINE-SHOP-MAIN/E-Commerce/thankyou.php");
    }
?>