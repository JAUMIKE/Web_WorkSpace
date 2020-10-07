<?php
require_once("connectSql.php");
if(isset($_POST["customerName"]) && ($_POST["customerName"]!="")){
	//購物車開始
    require_once("mycart.php");
    session_start();
	$cart =& $_SESSION['cart']; // 將購物車的值設定為 Session
	if(!is_object($cart)) $cart = new myCart();
	//購物車結束	
	//新增訂單資料
	$sql_query = "INSERT INTO orders (total ,grandtotal ,customerName ,customerEmail ,customerAddress ,customerPhone ,paytype) VALUES (?, ?, ?, ?, ?, ?, ?)";
	$stmt = $link->prepare($sql_query);
	$stmt->bind_param("iisssss", $cart->total, $cart->grandtotal, $_POST["customerName"], $_POST["customerEmail"], $_POST["customerAddress"], $_POST["customerPhone"], $_POST["paytype"]);
	$stmt->execute();
	//取得新增的訂單編號
	$o_pid = $stmt->insert_id;
	$stmt->close();
	//新增訂單內貨品資料
	if($cart->itemcount > 0) {
		foreach($cart->get_contents() as $item) {
			$sql_query="INSERT INTO orderdetail (orderId ,productId ,productName ,productPrice ,productQty) VALUES (?, ?, ?, ?, ?)";
			$stmt = $link->prepare($sql_query);
			$stmt->bind_param("iisii", $o_pid, $item['id'], $item['info'], $item['price'], $item['qty']);
			$stmt->execute();
			$stmt->close();
		}
	}
	//郵寄通知
	$cname = $_POST["customerName"];
	$cmail = $_POST["customerEmail"];
	$ctel = $_POST["customerPhone"];
	$caddress = $_POST["customerAddress"];
	$cpaytype = $_POST["paytype"];
	$total = $cart->grandtotal;
	$mailcontent=<<<msg
	親愛的 $cname 您好：
	感謝您的光臨
	本次消費詳細資料如下：
	--------------------------------------------------
	訂單編號： $o_pid 
	客戶姓名：$cname 
	電子郵件： $cmail 
	電話： $ctel 
	住址： $caddress 
	付款方式： $cpaytype 
	消費金額：	$total 
	--------------------------------------------------
	希望能再次為您服務 
	
	野球魂購物公司 敬上
msg;
	// $mailFrom="=?UTF-8?B?" . base64_encode("網路購物系統") . "?= <service@e-happy.com.tw>";
	// $mailto = $_POST["customeremail"];
	// $mailSubject="=?UTF-8?B?" . base64_encode("網路購物系統訂單通知"). "?=";
	// $mailHeader="From:".$mailFrom."\r\n";
	// $mailHeader.="Content-type:text/html;charset=UTF-8";
    // if(!@mail($mailto,$mailSubject,nl2br($mailcontent),$mailHeader)){
    //     // die("郵寄失敗！");
    //     echo "郵寄失敗";
    //     echo "<script>window.location.href='cartreport.php'</script>";
        
    // } 
   
	//清空購物車
	// $cart->empty_cart();
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
    <link rel="stylesheet" href="css/cartreport.css">
    <title>棒球器具購物網</title>
    <script src="js/index.js"></script>
    
    </head>
    <body>
        <div class="container mt-5">
            <div class="row">
                <div class="col-3"></div>
                <div class="col-6 border border-white shadow">
                    <div>
                        <p class="m-3">親愛的<span class="text-primary font-weight-bold"><?php echo  $cname; ?></span>你好</p>
                        <p class="m-3">感謝您的光臨</p>
                        <p class="m-3">本次消費詳細資料如下：</p>
                        <hr>
                        <div class="row">
                            <div class="col-6"> 
                                <label class="m-3" for="">訂單編號： <span><?php echo $o_pid  ?></span></label><br> 
                                <label class="m-3" for="">客戶姓名： <span><?php echo $cname  ?></span></label><br> 
                                <label class="m-3" for="">電子郵件： <span><?php echo $cmail  ?></span></label><br> 
                                <label class="m-3" for="">電話： <span><?php echo $ctel ?></span></label><br> 
                                <label class="m-3" for="">住址： <span><?php echo $caddress ?></span></label><br> 
                                <label class="m-3" for="">付款方式： <span><?php echo $cpaytype   ?></span></label><br> 
                                <label class="m-3" for="">消費金額： <span class="text-danger"><?php echo $total ?> 元</span></label>
                            </div>
                            <div class="col-6">
                                <img class="my-4" style="object-fit:contain;" src="image/gif004.gif" alt="">
                            </div>  
                        </div>
                         
                        <hr>
                        <p class="m-3">希望能再次為您服務</p>
                        <p class="m-3">野球魂購物公司 敬上</p>
                        <div class="d-flex justify-content-center my-2"> 
                            <button type="button" name="btnBack" class="btn btn-outline-success" onclick="backtoIndex()">點我回首頁</button>  
                        </div>
                    </div>


                </div>
                <div class="col-3"></div>

            </div>

        </div>

    <script src="js/jquery.min.js"></script>
    <script src="js/popper.min.js"></script>
	<script src="js/bootstrap.min.js"></script>
	<script language="javascript">
        function backtoIndex(){
            alert("感謝您的購買，我們將儘快進行處理。");
            // window.location.href="indexPage.php";
            <?php 
                 $cart->empty_cart();
            ?>
            location.href = "indexPage.php";
        }
	</script>
    </body>
    </html>

