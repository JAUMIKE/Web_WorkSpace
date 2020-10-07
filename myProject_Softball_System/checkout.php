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
    if(!is_object($cart)){
        $cart = new myCart();
    } 
    //購物車結束
    //繫結產品目錄資料
    $query_RecCategory = "SELECT category.categoryId, category.categoryName, count(product.productId) as productNum FROM category LEFT JOIN product ON category.categoryId = product.categoryId GROUP BY category.categoryId, category.categoryName ORDER BY category.categoryId ASC";
    $RecCategory = $link->query($query_RecCategory);
    //計算資料總筆數
    $query_RecTotal = "SELECT count(productId)as totalNum FROM product";
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
    <link rel="stylesheet" href="css/checkout.css">
    <title>棒球器具購物網</title>
    <script src="js/index.js"></script>
    <script src="js/checkout.js"></script>
    
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
                <li   li class="nav-item active">
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
                       <!-- <input class="form-control mr-sm-2" type="search" placeholder="Search" aria-label="Search"> -->
                <?php if(!isset($_SESSION["loginMember"])||($_SESSION["loginMember"]=="")) : ?>
                    <button class="btn btn-outline-success my-2 my-sm-0" onclick="" type="submit"><a id="loginText" class="text-white btn" href="login.php">登入 / 註冊</a></button>
                <?php else: ?>    
                    <button class="btn btn-outline-warning my-2 my-sm-0" onclick="" type="submit"><a id="" class="text-white btn" href="?logout=true">登出</a></button>    
                    <!-- <button class="btn btn-outline-warning my-2 my-sm-0" onclick="" type="submit"><a class="text-white btn" href="login.php">登出</a></button>     -->
                <?php   endif; ?>
                </li>
            </ul>
            <form class="form-inline my-2 my-lg-0">
                <!-- <input class="form-control mr-sm-2" type="search" placeholder="Search" aria-label="Search"> -->
              
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
                <div class="col-1 px-0 mx-auto pl-5"><a href="cart.php"><img class="imgSize" src="image/shoppingCart01.svg" alt=""></a></div>
                <div class="col-1 px-0"><a href="cart.php"><span class="badge badge-danger"><?php echo number_format($cart->itemcount);?></span></a></div>
            </div>    
            <!-- 進入商品頁後商品名稱 -->
            <div class="h4 my-4">購物車清單</div>
            <hr>
            <div >
                <?php if($cart->itemcount > 0) {?>
                    <table class="table table-hover">
                        <thead class="thead-dark">
                            <tr>
                              <th scope="col">#</th>
                              <th scope="col">商品名稱</th>
                              <th scope="col">數量</th>
                              <th scope="col">單價</th>
                              <th scope="col">小計</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                                $i=0;
                                foreach($cart->get_contents() as $item) { 
                                $i++;    
                            ?>    
                                <tr>
                                <th scope="row"><?php echo number_format($item['id']);?></th>
                                <td><?php echo $item['info'];?></td>
                                <td><?php echo $item['qty'];?></p></td>
                                <td><span>$ <?php echo number_format($item['price']);?></span></td>
                                <td><span>$ <?php echo number_format($item['subtotal']);?></span></td>
                                </tr>
                            <?php }?>
                        </tbody>
                    </table>
                    <?php }else{ ?>
                        <div class="infoDiv">目前購物車是空的。</div>
                    <?php } ?>
                    <hr>
                    <div class="row">
                        <div class="col-2"></div>
                        <div class="col-6">
                        </div>
                        <div class="col-4"><span class="h4">總計: $ <span class="h4 text-danger"><?php echo number_format($cart->grandtotal);?></span> 元</span></div>                        
                    </div>  
            </div>
            <br>
            <div class="cartDetail ">
                <div class="row">
                    <div class="col-3"></div>        
                    <div class="col-6 border border-wite p-4 shadow">
                        <div class="row">
                            <div class="col-3"></div>
                            <div class="col-6"><p class="h2 text-center text-success px-0">訂購資訊填寫</p></div>
                            <div class="col-3 px-0 py-1"><img class="imgSize" src="image/shoppingCart02.ico" alt=""></div>
                        </div>
                        
                        <hr size="4">
                        <form action="cartreport.php" method="post" name="cartform" id="cartform" onSubmit="return checkForm();">
                            <div class="form-group">
                                <label for="customerName">訂購人姓名 <sup class="text-danger"> * </sup> : </label>
                                <input type="text" class="form-control" id="customerName" name="customerName" placeholder="請輸入姓名">
                            </div>   
                            <div class="form-group">
                                <label for="customerPhone">訂購人電話 <sup class="text-danger"> * </sup> : </label>
                                <input type="text" class="form-control" id="customerPhone" name="customerPhone" placeholder="請輸入電話">
                            </div>   
                            <div class="form-group">
                                <label for="customerEmail">電子信箱 <sup class="text-danger"> * </sup> : </label>
                                <input type="text" class="form-control" id="customerEmail" name="customerEmail" placeholder="請輸入Email">
                            </div>   
                            <div class="form-group">
                                <label for="customerAddress">住址 <sup class="text-danger"> * </sup> : </label>
                                <input type="text" class="form-control" id="customerAddress" name="customerAddress" placeholder="請輸入地址">
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-4">
                                    <label for="inputState">消費方式</label>
                                    <select id="paytype" name="paytype" class="form-control">
                                        <option value="ATM匯款" selected>ATM匯款</option>
                                        <option value="信用卡支付">信用卡支付</option>
                                        <option value="貨到付款">貨到付款</option>
                                    </select>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-2"></div>
                                <div class="col-8 d-flex justify-content-center">
                                    <input name="cartaction" type="hidden" id="cartaction" value="update">
                                    <button type="submit" class="btn btn-primary mx-2" name="updatebtn" id="button3">送出訂購單</button>
                                    <button class="btn btn-info mx-2" name="backbtn" id="button4" value="回上一頁" onClick="window.history.back();">回上一頁</button>
                                </div>
                                <div class="col-2"></div>
                            </div>
                            
                        </form>
                    </div>        
                    <div class="col-3"></div>        

                </div>
            </div>
        </div> 
        <div class="h-50">
        <footer class="bg-dark font-weight-bold text-light text-center">野球魂購物城</footer>
         </div>
    </div>    
    <script>
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