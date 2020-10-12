<?php
    $dbname = "localhost";
    $dbloginName = "root";
    $dbloginPwd = "";
    $usedbName = "softsystem";
    $link = mysqli_connect($dbname,$dbloginName,$dbloginPwd);
    mysqli_select_db($link,$usedbName);
    // $result = mysqli_query($link,"select * from memberdata");
    if($link->connect_error !=""){
        echo "資料庫連線失敗";
    }else{
        mysqli_query($link,"set names 'utf-8'");
    }

?>