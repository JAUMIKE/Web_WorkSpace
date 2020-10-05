<?php
    //宣告涵式來過濾、轉譯
    function GetSQLValueString($theValue, $theType) {
        switch ($theType) {
        //當資料型態為字串時，過濾符號 ""、''、\
          case "string":
            $theValue = ($theValue != "") ? filter_var($theValue, FILTER_SANITIZE_MAGIC_QUOTES) : "";
            break;
         //當資料型態為整數時，刪除除了數字和+-以外的字元
          case "int":
            $theValue = ($theValue != "") ? filter_var($theValue, FILTER_SANITIZE_NUMBER_INT) : "";
            break;
        //驗證是否為電子郵件
          case "email":
            $theValue = ($theValue != "") ? filter_var($theValue, FILTER_VALIDATE_EMAIL) : "";
            break;
       
      }
      return $theValue;
    }
     //找尋帳號是否已註冊,如果收到表單的POST["action"]有join則有送出填寫值就可以繼續往下處理
     if(isset($_POST["action"]) && ($_POST["action"]=="join")){
        require_once("connectSql.php");
        //比對資料庫與表單所接收到的帳號資訊
        $query_RecFindUser = "SELECT m_username FROM memberdata WHERE m_username='{$_POST["m_username"]}'";
        $RecFindUser=$link->query($query_RecFindUser);
        //若帳號已註冊，則導回原頁並帶參數errMsg=1於網址上
        if ($RecFindUser->num_rows>0){
            header("Location: signup.php?errMsg=1&username={$_POST["m_username"]}");
        }else{
            //若沒有人使用該帳號則執行新增動作
            $query_insert = "INSERT INTO memberdata (m_name, m_username, m_passwd, m_sex, m_birthday, m_email, m_phone, m_address, m_jointime)  VALUES(?,?,?,?,?,?,?,?,NOW())";
            $stmt = $link->prepare($query_insert);
            //使用涵式過濾填入的欄位資料並使用預備語法執行新增，其中密碼採用加密的方式儲存
            $stmt->bind_param("ssssssss",
                GetSQLValueString($_POST["m_name"],"string"),
                GetSQLValueString($_POST["m_username"],"string"),
                password_hash($_POST["m_passwd"],PASSWORD_DEFAULT),
                GetSQLValueString($_POST["m_sex"],"string"),
                GetSQLValueString($_POST["m_birthday"],"string"),
                GetSQLValueString($_POST["m_email"],"email"),
                GetSQLValueString($_POST["m_phone"],"string"),
                GetSQLValueString($_POST["m_address"],"string"));
            $stmt->execute();
            //執行完畢後關閉資料庫物件
            $stmt->close();
            $link->close();
            //新增完畢後重新導回原頁
            header("Location:signup.php?loginStats=1");
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

      .fontsmClass{
        font-size: 13px;
        /* vertical-align:super; */
        
      }
    </style>
    <script src="js/signup.js"></script>
</head>

<body>
    <?php if(isset($_GET["loginStats"]) && ($_GET["loginStats"]=="1")){?>
        <script language="javascript">
            alert('會員新增成功\n請用申請的帳號密碼登入。');
            window.location.href='login.php';
            // window.close();	  
        </script>
    <?php }?>
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
                    <div class="w-50 d-flex">
                        <button id="loginBtn" type="button" onclick="intoLoginPage()" class="btn btn-outline-primary w-100 m-4"
                            data-toggle="buttons">會員登入</button>
                    </div>
                    <div class="w-50 d-flex justify-content-center">
                        <button id="signBtn" type="button" onclick="intoSignupPage()" class="btn bg-primary text-white w-100 m-4"
                            data-toggle="buttons">註冊</button>
                    </div>
                </div>
                <div class="row">
                    <div class="col">
                        <form method="post" action="" name="formJoin" id="formJoin" onSubmit="return checkForm();">
                            <div class=""><p class="text-center">帳號註冊<span class="fontsmClass">(<sup class="text-danger"> * </sup>為必填欄位)</span> </p></div> 
                            <?php if(isset($_GET["errMsg"]) && ($_GET["errMsg"]=="1")) { ?>
                                <div class="errDiv">
                                    <p class="text-danger text-center">帳號 <?php echo $_GET["username"];?> 已有人使用!</p>
                                </div>
                            <?php }?>
                            <div class="form-group">
                                <label for="m_username">帳號 <sup class="text-danger"> * </sup>: </label>
                                <input type="text" class="form-control" id="m_username" name="m_username"  placeholder="請輸入使用帳號">
                                <small><span class="fontsmClass text-dark">-請填入5至12個字元以內的小寫英文字母、數字、以及_ 符號。</span></small>
                            </div>
                            <div class="form-group">
                                <label for="m_passwd">密碼 <sup class="text-danger"> * </sup>: </label>
                                <input type="password" class="form-control" id="m_passwd" name="m_passwd" placeholder="請輸入密碼">
                                <small><span class="fontsmClass text-dark">-請填入5~10個字元以內的英文字母、數字、以及各種符號組合</span></small>
                            </div>
                            <div class="form-group">
                                <label for="m_passwdrecheck">確認密碼 <sup class="text-danger"> * </sup>: </label>
                                <input type="password" class="form-control" id="m_passwdrecheck" name="m_passwdrecheck" placeholder="請輸入密碼">
                                <small><span class="fontsmClass text-dark">-再次輸入密碼</span></small>
                            </div>
                            <hr>
                            <div><p class="text-center">個人資料<span class="fontsmClass">(<sup class="text-danger"> * </sup>為必填欄位)</span> </p></div>
                            <div class="form-group">
                                <label for="m_name">姓名 <sup class="text-danger"> * </sup>: </label>
                                <input type="text" class="form-control" id="m_name" name="m_name" placeholder="請輸入真實姓名">
                            </div>
                            <div class="form-group">
                                <label for="m_sex">性別 <sup class="text-danger"> * </sup>: </label><br>
                                <input name="m_sex" id="m_sex_man" type="radio" value="男" checked><label for="m_sex_man" class="h5">男</label>
                                <input name="m_sex" id="m_sex_woman" type="radio" value="女"><label for="m_sex_woman" class="h5">女</label>
                            </div>
                            <div class="form-group">
                                <label for="m_birthday">生日 <sup class="text-danger"> * </sup>: </label>
                                <input type="text" class="form-control" id="m_birthday" name="m_birthday" placeholder="請輸入出生年月日">
                                <small><span class="fontsmClass text-dark">-輸入西元年格式 : 1990-01-01</span></small>
                            </div>
                            <!-- <div class="form-group">
                                <label for="m_birthday">生日 <sup class="text-danger"> * </sup>: </label>
                                <input type="date" class="form-control" id="m_birthday" name="m_birthday" placeholder="請輸入出生年月日">
                                <small><span class="fontsmClass text-dark">-輸入西元年格式 : 1990-01-01</span></small>
                            </div> -->
                            <div class="form-group">
                                <label for="m_email">電子郵件 <sup class="text-danger"> * </sup>: </label>
                                <input type="text" class="form-control" id="m_email" name="m_email" placeholder="請輸入e-Mail信箱">
                                <small><span class="fontsmClass text-dark">-確認是可使用的電子郵件信箱</span></small>
                            </div>
                            <div class="form-group">
                                <label for="m_phone">電話 : </label>
                                <input type="text" class="form-control" id="m_phone" name="m_phone" placeholder="請輸入電話">
                            </div>
                            <div class="form-group">
                                <label for="m_address">住址 : </label>
                                <input type="text" class="form-control" id="m_address" name="m_address" placeholder="請輸入住址">
                            </div>

                            <div class="form-group d-flex justify-content-center">
                                <!-- 表單送出所抓的資料 -->
                                <input name="action" type="hidden" id="action" value="join">
                                <button type="submit" class="btn btn-outline-success w-50 my-3">送出</button>
                            </div>
                        </form>
                    </div>
                </div>

            </div>
            <div class="col-2"></div>
        </div>

    </div>
</body>

<script src="js/jquery.min.js"></script>
<script src="js/popper.min.js"></script>
<script src="js/bootstrap.min.js"></script>

</html>