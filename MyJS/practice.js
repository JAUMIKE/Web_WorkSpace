function total(a,b){
    document.write(a+b);
} 
//讓按鍵可以隱藏/顯示表單
function showMsg(){
    //formDisplay 取得當前表單顯示狀態(display)  
    var formDisplay = window.getComputedStyle(document.getElementById('formArea')).getPropertyValue('display');
    //btnDisplay 取得當前按鍵顯示文字
    var btnDisplay =  document.getElementById('btnShow').innerText;
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
//利用visibilit修改表單顯示狀態
function showMsgVis(){
    //formDisplay 取得當前表單顯示狀態(visibility)  
    var formDisplay = window.getComputedStyle(document.getElementById('formArea')).getPropertyValue('visibility');
    console.log(formDisplay)
    //btnDisplay 取得當前按鍵顯示文字
    var btnDisplay =  document.getElementById('btnShowOn').innerText;
    console.log(btnDisplay);
    //判斷按鍵顯示文字內容,並隨click事件修改內容
    if(btnDisplay == 'Show Me ON'){
        document.getElementById('btnShowOn').innerText='Hide Me Off';
    }else{
        document.getElementById('btnShowOn').innerText='Show Me ON';
    }
    //判斷表單顯示狀態並隨click事件修改顯示狀態
    if(formDisplay=='hidden'){
        document.getElementById('formArea').style.visibility='visible';
    }else{
        document.getElementById('formArea').style.visibility='hidden'
    }
    
}

function hideMsg(){
    document.getElementById('formArea').style.display='none';
}

function showNum(){
    document.getElementById('printNum').innerHTML='123'
}