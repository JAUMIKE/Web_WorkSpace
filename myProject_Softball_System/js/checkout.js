function checkForm(){	
    if(document.cartform.customerName.value==""){
        alert("請填寫姓名!");
        document.cartform.customerName.focus();
        return false;
    }
    if(document.cartform.customerEmail.value==""){
        alert("請填寫電子郵件!");
        document.cartform.customerEmail.focus();
        return false;
    }
    if(!checkmail(document.cartform.customerEmail)){
        document.cartform.customerEmail.focus();
        return false;
    }	
    if(document.cartform.customerPhone.value==""){
        alert("請填寫電話!");
        document.cartform.customerPhone.focus();
        return false;
    }
    if(document.cartform.customerAddress.value==""){
        alert("請填寫地址!");
        document.cartform.customerAddress.focus();
        return false;
    }
    return confirm('確定送出嗎？');
}
function checkmail(myEmail) {
    var filter  = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
    if(filter.test(myEmail.value)){
        return true;
    }
    alert("電子郵件格式不正確");
    return false;
}