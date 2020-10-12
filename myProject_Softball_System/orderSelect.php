<?php
     require_once("connectSql.php");
     session_start();
     if(isset($_GET["logout"]) && ($_GET["logout"])=="true"){
        unset($_SESSION["loginMember"]);
        unset($_SESSION["memberLevel"]);
        header("location: indexPage.php");  
    }
    $cart =& $_SESSION['cart']; // 將購物車的值設定為 Session
    if(!is_object($cart)){
        $cart = new myCart();
    } 
    //  $order_Select =   "SELECT * FROM orders WHERE orderid=? and customerName=?";
     $order_Select =   "SELECT A.orderid,A.total,A.customerName,A.customerEmail,A.customerAddress,A.customerPhone,A.paytype,B.productId,B.productName FROM orders A 
     left join orderdetail B
     on A.orderid = B.orderId
     WHERE A.orderid = ? and A.customerName =?";
     //設定查詢訂單的語法
     $stmt = $link->prepare($order_Select);
     //用get方法拿到orderid、customerName
     $stmt->bind_param("is", $_GET["orderid"],$_GET["customerName"]);
     $stmt->execute();
     $RecOrder = $stmt->get_result();
     $row_RecOrder = $RecOrder->fetch_assoc();

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/orderSelect.css">
</head>
<body>
<nav class="navbar  navbar-dark bg-dark">
        <div class="container">
            <div><a href=""><img class="logoImg" src="image/logo2.png" alt=""></a></div>
            <div class="" id="navbarSupportedContent"></div>

            <ul class="nav ml-auto">
                <li class="nav-item active">
                    <a class="nav-link text-white" href="indexPage.php">首頁 <span class="sr-only">(current)</span></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link  text-white" href="#" target="_blank">訂單查詢</a>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle  text-white" href="#" id="navbarDropdown" role="button"
                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">數據查詢</a>
                    <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                        <a class="dropdown-item  text-danger" href="#">施工中</a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item  text-danger" href="#">施工中</a>
                    </div>
                </li>
                <li>
                    
                </li>
            </ul>
            <form class="form-inline my-2 my-lg-0">
                <!-- <input class="form-control mr-sm-2" type="search" placeholder="Search" aria-label="Search"> -->
                <?php if(!isset($_SESSION["loginMember"])||($_SESSION["loginMember"]=="")) : ?>
                    <button class="btn btn-outline-success my-2 my-sm-0" onclick="" type="submit"><a id="loginText" class="text-white btn" href="login.php">登入 / 註冊</a></button>
                <?php else: ?>    
                    <button class="btn btn-outline-warning my-2 my-sm-0" onclick="" type="submit"><a id="" class="text-white btn" href="?logout=true">登出</a></button>    
                    <!-- <button class="btn btn-outline-warning my-2 my-sm-0" onclick="" type="submit"><a class="text-white btn" href="login.php">登出</a></button>     -->
                <?php   endif; ?>
            </form>
        </div>
    </nav>

    <div class="container my-3">
                    
        <form action="" class="d-flex justify-content-center" method="get">
            <div class="form-row">
                <div class="form-group mx-3">
                    <label for="orderid">訂單編號 : </label>
                    <input type="text" name="orderid" id="orderid"  placeholder="請輸入訂單編號">
                </div>
                <div class="form-group mx-3">
                    <label for="">訂購人姓名 : </label>
                    <input type="text" name="customerName" id="customerName"  placeholder="請輸入訂購人姓名">
                </div>
                <div class="form-group">
                    <button class="btn btn-outline-success mx-3" onclick="">提交</button>
                </div>
            </div><br>
           
            <!-- <input type="text" name="customerName" id="customerName"  placeholder="請輸入訂購人姓名"><br> -->
           
        </form>
        <hr>
        <div class="row">
            <div class="col-4">
                <img id="gifImg01" src="" alt="">
            </div>
            <div class="col-4 border border-dark shadow">
                <p class="my-2">Hello! <span class="text-primary font-weight-bold"><?php echo $row_RecOrder["customerName"]?> </span>你所查詢的訂單資訊如下:</p>
                <hr>
                <label for="">訂單編號 : <span id="myorderId"><?php echo $row_RecOrder["orderid"]?></span></label><br>
                <label for="">訂購人姓名 : <span><?php echo $row_RecOrder["customerName"]?></span></label><br>
                <label for="">訂購人電話 : <span><?php echo $row_RecOrder["customerPhone"]?></span></label><br>
                <label for="">訂購人Email : <span><?php echo $row_RecOrder["customerEmail"]?></span></label><br>
                <label for="">訂購人住址 : <span><?php echo $row_RecOrder["customerAddress"]?></span></label><br>
                <label for="">消費金額 : <span class="text-danger"><?php echo $row_RecOrder["total"]?></span></label><br>
                <label for="">付款方式 : <span><?php echo $row_RecOrder["paytype"]?></span></label><br>
                 <hr>
                <p>感謝你的支持，若有問題請打<span class="text-info">04-95279527</span></p>   
                <p>會有專人為你服務</p>
            </div>
            <div class="col-4">
                 <img id="gifImg02" src="" alt="">
            </div>
        </div>
    </div>
    <script>
        function showGif(){
            document.getElementById('gifImg02').setAttribute('src','image/gif002.gif')
            document.getElementById('gifImg01').setAttribute('src','image/gif001.gif')
        }
        let labOrderId = document.getElementById("myorderId");
        if( labOrderId.innerText !=""){
            showGif();
        }
    </script>
    <script src="js/jquery.min.js"></script>
    <script src="js/popper.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
</body>
</html>