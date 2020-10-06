<?php 
  require_once 'connectSql.php';
  session_start();
  if(isset($_GET["logout"]) && ($_GET["logout"])=="true"){
      unset($_SESSION["loginMember"]);
      unset($_SESSION["memberLevel"]);
      header("location: indexPage.php");  
  }
  //預設顯示資料筆數
  $pageRow_records = 6;
 //預設頁數
  $num_pages = 1;

  //若已經有翻頁，將頁數更新
  if (isset($_GET['page'])) {
        $num_pages = $_GET['page'];
    }
    //本頁開始記錄筆數 = (頁數-1)*每頁記錄筆數
  $startRow_records = ($num_pages -1) * $pageRow_records;
  //若有分類關鍵字時未加限制顯示筆數的SQL敘述句
if(isset($_GET["cid"])&&($_GET["cid"]!="")){
	$query_RecProduct = "SELECT * FROM product WHERE categoryId=? ORDER BY productId DESC";
	$stmt = $link->prepare($query_RecProduct);
	$stmt->bind_param("i", $_GET["cid"]);
//若有搜尋關鍵字時未加限制顯示筆數的SQL敘述句
}elseif(isset($_GET["keyword"])&&($_GET["keyword"]!="")){
	$query_RecProduct = "SELECT * FROM product WHERE productname LIKE ? OR description LIKE ? ORDER BY productid DESC";
	$stmt = $db_link->prepare($query_RecProduct);
	$keyword = "%".$_GET["keyword"]."%";
	$stmt->bind_param("ss", $keyword, $keyword);	
//預設狀況下未加限制顯示筆數的SQL敘述句
}else{
	$query_RecProduct = "SELECT * FROM product ORDER BY productid DESC";
	$stmt = $link->prepare($query_RecProduct);
}


$stmt->execute();
//以未加上限制顯示筆數的SQL敘述句查詢資料到 $all_RecProduct 中
$all_RecProduct = $stmt->get_result();
//計算總筆數
$total_records = $all_RecProduct->num_rows;
//計算總頁數=(總筆數/每頁筆數)後無條件進位。
$total_pages = ceil($total_records/$pageRow_records);
//繫結產品目錄資料
$query_RecCategory = "SELECT category.categoryId, category.categoryName, count(product.productId) as productNum FROM category LEFT JOIN product ON category.categoryId = product.categoryId GROUP BY category.categoryId, category.categoryName ORDER BY category.categoryId ASC";
$RecCategory = $link->query($query_RecCategory);
//計算資料總筆數
$query_RecTotal = "SELECT count(productId) as totalNum FROM product";
$RecTotal = $link->query($query_RecTotal);
$row_RecTotal = $RecTotal->fetch_assoc();
//返回 URL 參數
function keepURL(){
	$keepURL = "";
	if(isset($_GET["keyword"])) $keepURL.="&keyword=".urlencode($_GET["keyword"]);	
	if(isset($_GET["cid"])) $keepURL.="&cid=".$_GET["cid"];
	return $keepURL;
}

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
</head>

<body>
    <!-- 導航列 -->
    <nav class="navbar  navbar-dark bg-dark">
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

    <!-- 導航列 end -->
    <!-- 網站內容 -->
    <!-- 圖片區 -->
    <div id="carouselExampleCaptions" class="carousel slide" data-ride="carousel">
        <ol class="carousel-indicators">
            <li data-target="#carouselExampleCaptions" data-slide-to="0" class="active"></li>
            <li data-target="#carouselExampleCaptions" data-slide-to="1"></li>
            <li data-target="#carouselExampleCaptions" data-slide-to="2"></li>
        </ol>
         <!-- 滑動圖片區 -->
        <div class="carousel-inner">
            <div class="carousel-item active">
                <img src="https://dummyimage.com/600x200/71c799/fff" class="d-block w-100 " alt="...">
                <div class="carousel-caption d-none d-md-block">
                    <h5>First slide label</h5>
                    <p>Nulla vitae elit libero, a pharetra augue mollis interdum.</p>
                </div>
            </div>
            <div class="carousel-item">
                <img src="https://dummyimage.com/600x200/fcc441/fff" class="d-block w-100" alt="...">
                <div class="carousel-caption d-none d-md-block">
                    <h5>Second slide label</h5>
                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit.</p>
                </div>
            </div>
            <div class="carousel-item">
                <img src="https://dummyimage.com/600x200/fa4141/fff" class="d-block w-100" alt="...">
                <div class="carousel-caption d-none d-md-block">
                    <h5>Third slide label</h5>
                    <p>Praesent commodo cursus magna, vel scelerisque nisl consectetur.</p>
                </div>
            </div>
        </div>
        <a class="carousel-control-prev" href="#carouselExampleCaptions" role="button" data-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="sr-only">Previous</span>
        </a>
        <a class="carousel-control-next" href="#carouselExampleCaptions" role="button" data-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="sr-only">Next</span>
        </a>
    </div>
   
    

    <!-- 商品card區 -->
    <div class="container my-3">
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
       
         <!--商品顯示區  -->
         <?php
            //加上限制顯示筆數的SQL敘述句，由本頁開始記錄筆數開始，每頁顯示預設筆數
            $query_limit_RecProduct = $query_RecProduct." LIMIT {$startRow_records}, {$pageRow_records}";
             //以加上限制顯示筆數的SQL敘述句查詢資料到 $RecProduct 中
            $stmt = $link->prepare($query_limit_RecProduct);
            //若有分類關鍵字時未加限制顯示筆數的SQL敘述句
			if(isset($_GET["cid"])&&($_GET["cid"]!="")){
				$stmt->bind_param("i", $_GET["cid"]);
			//若有搜尋關鍵字時未加限制顯示筆數的SQL敘述句
			}elseif(isset($_GET["keyword"])&&($_GET["keyword"]!="")){
				$keyword = "%".$_GET["keyword"]."%";
                $stmt->bind_param("ss", $keyword, $keyword);
            }	
            $stmt->execute();            
            $RecProduct = $stmt->get_result();
        ?>

        <div class="row col-12 my-1">
           <?php   while($row_RecProduct=$RecProduct->fetch_assoc()){ ?> 
                <div class="card col-4">
                    <a href="product.php?id=<?php echo $row_RecProduct["productId"];?>">
                        <?php if($row_RecProduct["productImg"]==""){?>
                            <img src="image/nopic.png" alt="暫無圖片"/>
                        <?php }else{?>
                        <img class="card-img-top" src="image/<?php echo $row_RecProduct["productImg"];?>" alt="<?php echo $row_RecProduct["productName"];?>">
                        <?php }?>
                        <div class="card-body">
                            <p class="card-text h6"><?php echo $row_RecProduct["productName"];?></p>
                            <a href="#" class="btn btn-primary">Go somewhere</a>
                        </div>
                    </a>
                </div>    
            <?php }?> 
        </div>
            <hr>
            <!-- 顯示下方頁碼 -->
        <div class="mr-2 " role="group" aria-label="First group">
            <ul class="pagination justify-content-center">
                 <?php          
                    for($i=1;$i<=$total_pages;$i++){
                        //點擊該頁的時候顯示點擊的狀態
                        if($i==$num_pages){
                            echo "<li class='page-item'><a class='page-link bg-primary text-white' href=''>".$i."</a></li>";
                        }else{
                            $urlstr = keepURL();
                            echo "<li class='page-item'><a class='page-link' href=\"?page=$i$urlstr\">".$i."</a></li>";
                            }
                    }
                ?>
            </ul>   
        </div>
    </div>
 
    <div class="h-50">
        <footer class="bg-dark font-weight-bold text-light text-center">F.T.I.F壘球小聯盟</footer>
    </div>
    <script src="js/jquery.min.js"></script>
    <script src="js/popper.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
</body>

</html>