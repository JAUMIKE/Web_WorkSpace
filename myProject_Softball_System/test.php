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
	$query_RecProduct = "SELECT * FROM product WHERE productModel LIKE ? OR productName LIKE ? ORDER BY productId DESC";
	$stmt = $link->prepare($query_RecProduct);
	$keyword = "%".$_GET["keyword"]."%";
	$stmt->bind_param("ss", $keyword, $keyword);	
//預設狀況下未加限制顯示筆數的SQL敘述句
}else{
	$query_RecProduct = "SELECT * FROM product ORDER BY productId DESC";
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
var_dump($row_RecTotal);
//返回 URL 參數
function keepURL(){
	$keepURL = "";
	if(isset($_GET["keyword"])) $keepURL.="&keyword=".urlencode($_GET["keyword"]);	
	if(isset($_GET["cid"])) $keepURL.="&cid=".$_GET["cid"];
	return $keepURL;
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
</head>
<body>
  <div class="navDiv">
              <?php if ($num_pages > 1) { // 若不是第一頁則顯示 ?>
              <a href="?page=1<?php echo keepURL();?>">|&lt;</a> <a href="?page=<?php echo $num_pages-1;?><?php echo keepURL();?>">&lt;&lt;</a>
              <?php }else{?>
              |&lt; &lt;&lt;
              <?php }?>
              <?php
                  for($i=1;$i<=$total_pages;$i++){
                      if($i==$num_pages){
                          echo $i." ";
                      }else{
                          $urlstr = keepURL();
                          echo "<a href=\"?page=$i$urlstr\">$i</a> ";
                      }
                  }
                ?>
              <?php if ($num_pages < $total_pages) { // 若不是最後一頁則顯示 ?>
              <a href="?page=<?php echo $num_pages+1;?><?php echo keepURL();?>">&gt;&gt;</a> <a href="?page=<?php echo $total_pages;?><?php echo keepURL();?>">&gt;|</a>
              <?php }else{?>
              &gt;&gt; &gt;|
              <?php }?>
            </div>

   <div class="btn-toolbar" role="toolbar" aria-label="Toolbar with button groups">
    <div class="btn-group mr-2" role="group" aria-label="First group">
    <?php
        for($i=1;$i<=$total_pages;$i++){
          if($i==$num_pages){
              echo "<button type='button' class='btn btn-primary'>".$i."</button>";
          }else{
              $urlstr = keepURL();
              echo "<button type='button' class='btn btn-secondary'><a href=\"?page=$i$urlstr\">".$i."</a></button>";
              // echo "<a href=\"?page=$i$urlstr\">$i</a> ";
          }
        }
      // <button type="button" class="btn btn-secondary">2</button>
      // <button type="button" class="btn btn-secondary">3</button>
      // <button type="button" class="btn btn-secondary">4</button>
      ?>
    </div>
    
 
  </div>
</div>          
</body>
</html>