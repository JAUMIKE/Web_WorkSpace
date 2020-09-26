//點文字後重新回到戰鬥頁
function replayGames(){
    let myid= document.getElementById('replayGame');
    let linkFunc = function(){
        location.href ="battle_update.html";
    }
    setTimeout(linkFunc,1000);
}


    // 播音樂，因為chrome阻擋自動撥放，因此使用點擊事件點網頁本身撥放
    let myAudio = document.getElementById('myMusic');
    window.addEventListener('click',function(){
        myAudio.play();
    })
 