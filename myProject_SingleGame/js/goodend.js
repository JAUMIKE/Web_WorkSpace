    // 播音樂，因為chrome阻擋自動撥放，因此使用點擊事件點網頁本身撥放
    let myAudio = document.getElementById('myMusic');
    window.addEventListener('click',function(){
        myAudio.play();
    })
 