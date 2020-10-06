<?php
    require_once("connectSql.php");
    //購物車開始
    require_once("mycart.php");
    session_start();
    $cart =& $_SESSION['cart']; // 將購物車的值設定為 Session
    if(!is_object($cart)){
        $cart = new myCart();
    } 
    // 更新購物車內容
    if(isset($_POST["cartaction"]) && ($_POST["cartaction"]=="update")){
        if(isset($_POST["updateid"])){
            $i=count($_POST["updateid"]);
            for($j=0;$j<$i;$j++){
                $cart->edit_item($_POST['updateid'][$j],$_POST['qty'][$j]);
            }
        }
        header("Location: cart.php");
    }
    
    // 移除購物車內容
    if(isset($_GET["cartaction"]) && ($_GET["cartaction"]=="remove")){
        $rid = intval($_GET['delid']);
        $cart->del_item($rid);
        header("Location: cart.php");	
    }
    // 清空購物車內容
    if(isset($_GET["cartaction"]) && ($_GET["cartaction"]=="empty")){
        $cart->empty_cart();
        header("Location: cart.php");
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
    <title>棒球器具購物網</title>
    <script src="js/index.js"></script>
    <style>
        .mainArea{
            height: 82vh;
        }
       
    </style>
</head>
<body>
    <div class="wrapperArea">
      <!-- 導航列 -->
      <nav class="navbar  navbar-dark bg-dark headerArea">
        <div class="container">
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#" aria-controls="" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <a class="navbar-brand mx-3" href="#">我的第1個網頁</a>

            <div class="" id="navbarSupportedContent"></div>

            <ul class="nav ml-auto">
                <li class="nav-item active">
                    <a class="nav-link text-white" href="index.php">首頁 <span class="sr-only">(current)</span></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link  text-white" href="#" target="_blank">選單(另開視窗)</a>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle  text-white" href="#" id="navbarDropdown" role="button"
                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">數據查詢</a>
                    <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                        <a class="dropdown-item  text-white" href="#">球隊數據</a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item  text-white" href="#">個人數據</a>
                    </div>
                </li>
                <li>
                    
                </li>
            </ul>
            <form class="form-inline my-2 my-lg-0">
                <!-- <input class="form-control mr-sm-2" type="search" placeholder="Search" aria-label="Search"> -->
                <?php if(!isset($_SESSION["loginMember"])||($_SESSION["loginMember"]=="")) : ?>
                    <button class="btn btn-outline-success my-2 my-sm-0" onclick="" type="submit"><a class="text-success" href="login.php">登入 / 註冊</a></button>
                <?php else: ?>    
                    <button class="btn btn-outline-warning my-2 my-sm-0" onclick="" type="submit"><a class="text-warning" href="?logout=true">登出</a></button>    
                <?php  endif; ?>
            </form>
        </div>
        </nav>
        <!-- 商品card區 -->
        <div class="container my-3 mainArea">
            <!-- 商品類別 -->
            <div>
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
            <!-- 進入商品頁後商品名稱 -->
            <div class="h4 my-4">購物車清單</div>
            <hr>
            <div>
                <?php if($cart->itemcount > 0) {?>
                <form action="" method="post" name="cartform" id="cartform">
                    <table class="table table-hover">
                        <thead class="thead-dark">
                            <tr>
                              <th scope="col">#</th>
                              <th scope="col">商品名稱</th>
                              <th scope="col">數量</th>
                              <th scope="col">單價</th>
                              <th scope="col">小計</th>
                              <th scope="col">刪除</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach($cart->get_contents() as $item) { ?>    
                                <tr>
                                <th scope="row"><?php echo number_format($item['id']);?></th>
                                <td><?php echo $item['info'];?></td>
                                <td>
                                    <input name="updateid[]" type="hidden" id="updateid[]" value="<?php echo $item['id'];?>">
                                    <input name="qty[]" type="text" id="qty[]" value="<?php echo $item['qty'];?>" size="1">
                                </td>
                                <td><span>$ <?php echo number_format($item['price']);?></span></td>
                                <td><span>$ <?php echo number_format($item['subtotal']);?></span></td>
                                <td><a href="?cartaction=remove&delid=<?php echo $item['id'];?>"><span class="badge badge-danger">移除</span></a></td> 
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
                            <input name="cartaction" type="hidden" id="cartaction" value="update">
                            <button class="btn btn-info" type="submit" name="updatebtn" id="button3" value="更新購物車">更新購物車</button>
                            <button class="btn btn-danger" type="button" name="emptybtn" id="button5" value="清空購物車" onClick="window.location.href='?cartaction=empty'">清空購物車</button>
                            <button class="btn btn-success" type="button" name="button" id="button6" value="前往結帳" onClick="window.location.href='checkout.php';">前往結帳</button>
                            <button class="btn btn-secondary" type="button" name="backbtn" id="button4" value="回上一頁" onClick="window.history.back();">回上一頁</button>
                        </div>
                        <div class="col-4"><span class="h4">總計: $ <span class="h4 text-danger"><?php echo number_format($cart->grandtotal);?></span> 元</span></div>
                        <div class="col-4"><span class="h4">總量:  <span class="h4 text-danger"><?php echo number_format($cart->itemcount);?></span> 項</span></div>
                    </div>
                </form>    
            </div>
        </div> 
        <div class="h-100 mt-4">
            <footer class="bg-dark font-weight-bold text-light text-center h4">F.T.I.F壘球小聯盟</footer>
        </div>
    </div>    
    <script src="js/jquery.min.js"></script>
    <script src="js/popper.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
</body>
</html>