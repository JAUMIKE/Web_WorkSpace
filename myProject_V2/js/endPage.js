//點文字後重新回到戰鬥頁
function replayGames(){
    let myid= document.getElementById('replayGame');
    let linkFunc = function(){
        location.href ="battle_update.html";
    }
    setTimeout(linkFunc,1000);
}