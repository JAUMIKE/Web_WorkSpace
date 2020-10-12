<?php
    require_once("connectSql.php");
    //購物車開始
    require_once("mycart.php");
    session_start();
    if(isset($_GET["logout"]) && ($_GET["logout"])=="true"){
        unset($_SESSION["loginMember"]);
        unset($_SESSION["memberLevel"]);
        header("location: indexPage.php");  
    }
    $cart =& $_SESSION['cart']; // 將購物車的值設定為 Session
    if(!is_object($cart)) $cart = new myCart();
    // 新增購物車內容
    if(isset($_POST["cartaction"]) && ($_POST["cartaction"]=="add")){
        $cart->add_item($_POST['id'],$_POST['qty'],$_POST['price'],$_POST['name']);
        header("Location: cart.php");
    }
   
    //購物車結束
    //繫結產品資料
    $query_RecProduct = "SELECT * FROM product WHERE productId=?";
    $stmt = $link->prepare($query_RecProduct);
    $stmt->bind_param("i", $_GET["id"]);
    $stmt->execute();
    $RecProduct = $stmt->get_result();
    $row_RecProduct = $RecProduct->fetch_assoc();
    //繫結產品目錄資料
    $query_RecCategory = "SELECT category.categoryId, category.categoryName, count(product.productId) as productNum FROM category LEFT JOIN product ON category.categoryId = product.categoryId GROUP BY category.categoryId, category.categoryName ORDER BY category.categoryId ASC";
    $RecCategory = $link->query($query_RecCategory);
    //計算資料總筆數
    $query_RecTotal = "SELECT count(productId) as totalNum FROM product";
    $RecTotal = $link->query($query_RecTotal);
    $row_RecTotal = $RecTotal->fetch_assoc();
?>

<!doctype html>
<html lang="zh_TW">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!-- Bootstrap CSS -->
    <!-- <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" integrity="sha384-WskhaSGFgHYWDcbwN70/dfYBj47jz9qbsMId/iRN3ewGhXQFZCSftd1LZCfmhktB" crossorigin="anonymous"> -->
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/product.css">
    <title>棒球器具購物網</title>
    <script src="js/index.js"></script>
    <script>
        function backtoTop(){window.location.assign("indexPage.php")}
    </script>
</head>
<body>
    <div class="wrapperArea">
      <!-- 導航列 -->
      <nav class="navbar  navbar-dark bg-dark headerArea">
        <div class="container">
            <!-- logo圖片 -->
            <div><a href=""><img class="logoImg" src="image/logo2.png" alt=""></a></div>
            <div class="" id="navbarSupportedContent"></div>

            <ul class="nav ml-auto">
                 <li class="nav-item active">
                    <a class="nav-link text-white" href="indexPage.php">首頁 <span class="sr-only">(current)</span></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link  text-white" href="orderSelect.php">訂單查詢</a>
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
                    <button class="btn btn-outline-warning my-2 my-sm-0" onclick="" type="submit"><a class="text-white btn" href="?logout=true">登出</a></button>    
                <?php  endif; ?>
            </form>
        </div>
        </nav>
        <!-- 商品card區 -->
        <div class="container my-3 mainArea">
            <!-- 商品類別 -->
            <div class="row">
                <div class="col-10">
                    <ul class="list-group list-group-horizontal">
                        <li class="list-group-item">
                            <a href="indexPage.php">所有商品 <span class="badge badge-primary badge-pill"><?php echo $row_RecTotal["totalNum"];?></span></a>
                        </li>
                        <?php while($row_RecCategory=$RecCategory->fetch_assoc()){ ?>
                        <li class="list-group-item">
                        <a href="indexPage.php?cid=<?php echo $row_RecCategory["categoryId"];?>" οnclick="js_method();return false;">
                            <?php echo $row_RecCategory["categoryName"]." ";?> 
                            <span class="badge badge-primary badge-pill"><?php echo $row_RecCategory["productNum"];?></span>
                        </a>
                        </li>
                        <?php }?>
                    </ul>
                </div>
                <!-- 購物車icon、購物車項次 -->
                <div class="col-1 px-0 mx-auto pl-5"><a href="cart.php"><img class="imgSize" src="image/shoppingCart01.svg" alt=""></a></div>
                <div class="col-1 px-0"><a href="cart.php"><span class="badge badge-danger"><?php echo number_format($cart->itemcount);?></span></a></div>
            </div>    
            <!-- 進入商品頁後商品名稱 -->
            <div class="h4 my-4"><?php echo($row_RecProduct["productName"]);?></div>
            <hr>
            <div class="row">
                <div class="col-2"></div>
                <div class="col-4 border-dark my-4">
                    <div class="row-cols-1">
                        <?php if($row_RecProduct["productImg"]==""){?>
                            <img src="images/nopic.png" alt="暫無圖片"/>
                            <?php }else{?>
                            <img class="justify-content-center" src="image/<?php echo $row_RecProduct["productImg"];?>" alt="<?php echo $row_RecProduct["productName"];?>"/>
                        <?php }?>
                    </div>
        
                </div>
                <div class="col-4 my-4">
                    <p class="h4 my-3"><span>型號 : </span><?php echo($row_RecProduct["productModel"]);?></p>
                    <p class="h4 my-3"><span>材質 : </span><?php echo($row_RecProduct["productDetail"]);?></p>
                    <p class="h4 my-3"><span>顏色 : </span> <?php echo($row_RecProduct["productColor"]);?></p>
                    <p class="h4 my-3"><span>重量 : </span><?php echo($row_RecProduct["productWeight"]);?></p>
                    <p  class="h4 my-3"><span class="smalltext justify-content-center">單價 </span><span class="justify-content-center text-danger"><?php echo $row_RecProduct["productPrice"];?></span><span class="smalltext justify-content-center"> 元</span></p>
                </div>
                <div class="col-2 border-dark"></div>

            </div>            
            <div class="row my-4">
                <div class="col-4"></div>
                <div class="col-4">
                    <form name="form3" method="post" action="">
                        <input name="id" type="hidden" id="id" value="<?php echo $row_RecProduct["productId"];?>">
                        <input name="name" type="hidden" id="name" value="<?php echo $row_RecProduct["productModel"];?>">
                        <input name="price" type="hidden" id="price" value="<?php echo $row_RecProduct["productPrice"];?>">
                        <input name="qty" type="hidden" id="qty" value="1">
                        <input name="cartaction" type="hidden" id="cartaction" value="add">
                        <div class="row">
                            <div class="col-6">
                            <input type="submit" class="btn btn-outline-primary my-2 mx-2 w-75" name="button3" id="button3" value="加入購物車">
                            </div>
                            <div class="col-6">
                            <input class="btn btn-outline-info my-2 mx-2 w-75" name="button4" id="button4" value="回上一頁" onClick="window.history.back();">  
                            </div>

                        </div>
                        
                       
                        <!-- <button type="submit" class="btn btn-outline-primary my-2 mx-2" name ="" >放入購物車</button>
                        <button class="btn btn-outline-info my-2 mx-2" onclick="toanotherPage()">回上一頁</button>    -->
                    </form>
                        
                </div>
                <div class="col-4"></div>
            </div>
        </div> 
    </div>    
    <div class="h-50">
        <footer class="bg-dark font-weight-bold text-light text-center">野球魂購物城</footer>
    </div>
    <script>
        function toanotherPage(){
            location.href = "indexPage.php";
        }
        //按登出鍵後回到登入頁
        let mybtn = document.getElementById("loginText");
        console.log(mybtn.innerText);
        if(mybtn.innerText = "登入 / 註冊"){
            location.href = "login.php";
        }
    </script>
    <script src="js/jquery.min.js"></script>
    <script src="js/popper.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
</body>
</html>