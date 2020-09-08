//讓按鍵可以隱藏/顯示表單
function showMsg(){
    //formDisplay 取得當前表單顯示狀態(display)  
    let formDisplay = window.getComputedStyle(document.getElementById('formArea')).getPropertyValue('display');
    //btnDisplay 取得當前按鍵顯示文字
    let btnDisplay =  document.getElementById('btnShow').innerText;
    console.log(btnDisplay);
    //判斷按鍵顯示文字內容,並隨click事件修改內容
    if(btnDisplay == 'Show Me'){
        document.getElementById('btnShow').innerText='Hide Me';
    }else{
        document.getElementById('btnShow').innerText='Show Me';
    }
    //判斷表單顯示狀態並隨click事件修改顯示狀態
    if(formDisplay=='none'){
        document.getElementById('formArea').style.display='block';
    }else{
        document.getElementById('formArea').style.display='none'
    }
    
}


//隨點擊次數放大圖片的按鍵
 function bigSize(){
     //widthSize、heightSize 取得img當前寬與高
    let widthSize = window.getComputedStyle(document.getElementById('ballImg')).getPropertyValue('width');
    let heightSize = window.getComputedStyle(document.getElementById('ballImg')).getPropertyValue('height');
    console.log(widthSize);
    console.log(heightSize);
    //將取到的寬與高轉成數值再加上要放大的像素後加上'px'轉成字串
    widthSize = parseInt(widthSize)+5+'px';
    heightSize = parseInt(heightSize)+5+'px';
    //改變寬與高(放大)
    document.getElementById('ballImg').style.width=widthSize;
    document.getElementById('ballImg').style.height=heightSize;
    
 }