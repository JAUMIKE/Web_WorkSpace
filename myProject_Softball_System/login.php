<?php
    require_once 'connectSql.php';
    session_start();
    if(isset($_SESSION["loginMember"]) && ($_SESSION["loginMember"]!="")){
        //若帳號等級為 member 則導向會員中心
        if($_SESSION["memberLevel"]=="member"){
            
            //實現登入成功後延遲跳轉頁面
            header("Refresh:3;url=indexPage.php");
            echo '<script>window.close();</script>';
            
        //否則則導向管理中心
        }else{
            header("Location: indexPage.php");	
        }
    }
    //執行會員登入
if(isset($_POST["username"]) && isset($_POST["passwd"])){
	//繫結登入會員資料
	$query_RecLogin = "SELECT m_username, m_passwd, m_level FROM memberdata WHERE m_username=?";
	$stmt=$link->prepare($query_RecLogin);
	$stmt->bind_param("s", $_POST["username"]);
	$stmt->execute();
	//取出帳號密碼的值綁定結果
	$stmt->bind_result($username, $passwd, $level);	
	$stmt->fetch();
	$stmt->close();
	//比對密碼，若登入成功則呈現登入狀態
	if(password_verify($_POST["passwd"],$passwd)){
		//計算登入次數及更新登入時間
		$query_RecLoginUpdate = "UPDATE memberdata SET m_login=m_login+1, m_logintime=NOW() WHERE m_username=?";
		$stmt=$link->prepare($query_RecLoginUpdate);
	    $stmt->bind_param("s", $username);
	    $stmt->execute();	
	    $stmt->close();
		//設定登入者的名稱及等級
		$_SESSION["loginMember"]=$username;
		$_SESSION["memberLevel"]=$level;
		//使用Cookie記錄登入資料
		if(isset($_POST["rememberme"])&&($_POST["rememberme"]=="true")){
			setcookie("remUser", $_POST["username"], time()+365*24*60);
			setcookie("remPass", $_POST["passwd"], time()+365*24*60);
		}else{
			if(isset($_COOKIE["remUser"])){
				setcookie("remUser", $_POST["username"], time()-100);
				setcookie("remPass", $_POST["passwd"], time()-100);
			}
		}
		//若帳號等級為 member 則導向會員中心
		if($_SESSION["memberLevel"]=="member"){
            //實現登入成功後延遲跳轉頁面
            header("Refresh:3;url=indexPage.php");
		//否則則導向管理中心
		}else{
			header("Location: indexPage.php");	
		}
	}else{
        header("Location: login.php?errMsg=1");
        // echo '<script>window.open("","_self").close()</script>';
	}
}


?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/bootstrap-grid.min.css.map">
    <link rel="stylesheet" href="css/bootstrap-reboot.min.css.map">
    <style>
        @font-face {
            font-family: "ヒラギノ角ゴ Pro W3", "Hiragino Kaku Gothic Pro", メイリオ, Meiryo, "ＭＳ Ｐゴシック", "MS PGothic", sans-serif;
            src: url(http://ameblo.jp);
        }

        body {
            font-family: "ヒラギノ角ゴ Pro W3", "Hiragino Kaku Gothic Pro", メイリオ, Meiryo, "ＭＳ Ｐゴシック", "MS PGothic", sans-serif;
            font-size: 24px;
        }

        #logoArea>div {
            /* height: 22vh; */
            text-align: center;
        }
        .errDiv{
            text-align: center;
        }
   
    </style>
    <script>
        function closeWindow(){
            window.open("","_self").close()  
        }
       
    </script>
</head>

<body>
    <div class="container mt-5 border border-light bg-light rounded shadow">
        <div id="mainArea" class="row">
            <div class="col-2"></div>
            <div class="col-8">
                <div class="row" id="logoArea">
                    <div class="col">
                        <img src="image/logo_1.png" alt="">
                    </div>
                    
                </div>
                <div class="row">
                <!-- <div><p class="text-center">會員登入</p></div> -->
                    <div class="w-50 d-flex">
                        <button id="loginBtn" type="button" class="btn bg-primary text-white w-100 m-4" data-toggle="buttons" onclick="intoLoginPage()">會員登入</button>
                    </div>
                    <div class="w-50 d-flex justify-content-center">
                        <button id="signBtn" type="button" onclick="intoSignupPage()" class="btn btn-outline-primary w-100 m-4"
                            data-toggle="buttons">註冊</button>
                    </div>
                </div>
                <div class="row">
                    <div class="col">
                        <form name="form1" method="post" action="">
                            <div class="form-group">
                                <label for="username">帳號 : </label>
                                <input type="text" class="form-control" name="username" id="username" placeholder="請輸入帳號" value="<?php if(isset($_COOKIE["remUser"]) && ($_COOKIE["remUser"]!="")) echo $_COOKIE["remUser"];?>">
                            </div>
                            <div class="form-group">
                                <label for="passwd">密碼 : </label>
                                <input type="password" class="form-control" id="passwd" name="passwd" placeholder="請輸入密碼" value="<?php if(isset($_COOKIE["remPass"]) && ($_COOKIE["remPass"]!="")) echo $_COOKIE["remPass"];?>">
                            </div>
                            <div class="form-group d-flex justify-content-center">
                                <button type="submit" class="btn btn-outline-success w-50 my-3">送出</button>
                            </div>
                        </form>
                        <!-- 如果有錯誤訊息代表帳號錯誤 -->
                        <?php if(isset($_GET["errMsg"]) && ($_GET["errMsg"]=="1")){?>
                        <div class="">
                            <p class="text-center text-danger">登入帳號或密碼錯誤！</p>
                        </div>
                        <!-- 如果session有值代表登入成功 -->
                        <?php }?>
                        <?php if(isset($_SESSION["loginMember"]) && ($_SESSION["loginMember"]!="")): ?>
                        <div>
                            <p class="text-center text-success">登入成功！</p>
                        </div>
                        <?php endif; ?>
                    </div>
                </div>

            </div>
            <div class="col-2"></div>
        </div>

    </div>
<script src="js/login_signupPage.js"></script>
<script src="js/jquery.min.js"></script>
<script src="js/popper.min.js"></script>
<script src="js/bootstrap.min.js"></script>

</body>

</html>