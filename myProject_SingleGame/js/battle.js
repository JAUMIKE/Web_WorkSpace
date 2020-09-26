let soundPlay = document.getElementById('mySound');
//設定BOSS屬性
let bossObjCenter = {
    'id': 'imgCenter',
    'src': 'https://dummyimage.com/200X200/ba5fba/7076d6',
    'hp': 3000,
    'damage': Math.floor(Math.random() * 100)
}
//設定男主屬性
let manPlayerObj = {
    'hp': 999,
    'damage': Math.floor(Math.random() * 1000)
}

// 因為特效結束後會有殘影留在圖上，所以要再把特效圖片清空
function clearEffect() {
    document.getElementById('hitEffect01').setAttribute('src', '');
}
//對方回合  
function opponentTurn() {
    console.log('輪到對手回合')
    //取得主角HP存在變數myRoleHp01
    let myRoleHp01 = manPlayerObj.hp;
    //亂數取得BOSS傷害
    let bossDamage = Math.floor(Math.random() * 1000);
    //戰鬥資訊欄第三個p標籤
    let mydemo3 = document.getElementById('demo3');
    //取得回合顯示資訊欄(battleInfo第一個p標籤)
    let demoInfo = document.getElementById('demo1');
    //取得BOSS特效施放區域
    let opponentEffect = document.getElementById('bossEffect');
    //取得我方人物狀態div區域，用作生命值受損時附加css濾鏡
    let myRoleArea = document.getElementById('anotherRoleplay01');
    //取得生命條展示區域(黑底部分)
    let showMyHp = document.getElementById('myHp');
    //取得生命條展示區域(紅色部分)
    let myHpWidth = document.getElementById('myHpArea');
    //設定換頁網址(當我方生命值歸零)
    let changePage = function () {
        location.href = "endPage.html"
    }
    //設定我方狀態濾鏡
    let changeMyRoleStyle = function () {
        myRoleArea.style.filter = 'grayscale(1)';
    }
    //清除特效函式
    let clearbossEffect = function () {
        opponentEffect.setAttribute('src', '');
    }
    //攻擊特效附加、並於指定秒數後清除特效
    let attackEffect = function () {
        opponentEffect.setAttribute('src', '../image/burstV1.gif');
        setTimeout(clearbossEffect, 1500);
    }
    let changeMyRound = function () {
        demoInfo.innerText = "我方回合";
    }
    //受到BOSS攻擊後HP減少
    let myhpDecrease = function () {
        //當前HP - BOSS攻擊
        manPlayerObj.hp = manPlayerObj.hp - bossDamage;
        //判定生命值，當減去傷害後歸零，並且附加css黑白濾鏡並進入換頁
        if (manPlayerObj.hp <= 0) {
            manPlayerObj.hp = 0;
            mydemo3.innerText = `受到魔尊 ${bossDamage} 點傷害，當前HP : ${manPlayerObj.hp}，角色死亡`;
            //根據計算結果 顯示在戰鬥資訊欄
            showMyHp.innerText = manPlayerObj.hp;
            //根據計算結果顯示剩餘HP的血條(紅色)
            myHpWidth.style.width = Math.floor((manPlayerObj.hp / 999) * 100) + '%'
            //當hp<=0時加上濾鏡(黑白)
            myRoleArea.style.filter = 'grayscale(1)';
            setTimeout(changePage, 1500)
            // 判定生命值，當減去傷害後在下列區間，附加css另一種濾鏡
        } else if (manPlayerObj.hp > 0 && manPlayerObj.hp <= 400) {
            mydemo3.innerText = `受到魔尊 ${bossDamage} 點傷害，當前HP : ${manPlayerObj.hp}`;
            //根據計算結果 顯示在戰鬥資訊欄
            showMyHp.innerText = manPlayerObj.hp;
            //根據計算結果顯示剩餘HP的血條(紅色)
            myHpWidth.style.width = Math.floor((manPlayerObj.hp / 999) * 100) + '%'
            //當hp>0 && hp<=400 時加上濾鏡(另一種)
            myRoleArea.style.filter = 'saturate(0.3)';
        } else {
            mydemo3.innerText = `受到魔尊 ${bossDamage} 點傷害，當前HP : ${manPlayerObj.hp}`;
            //根據計算結果 顯示在戰鬥資訊欄
            showMyHp.innerText = manPlayerObj.hp;
            //根據計算結果顯示剩餘HP的血條(紅色)
            myHpWidth.style.width = Math.floor((manPlayerObj.hp / 999) * 100) + '%'
        }

    }
    //判斷BOSS血量>0的情況下才開始執行BOSS戰鬥階段，如果不執行判斷，當BOSS生命值歸零仍會繼續攻擊
    if (bossObjCenter.hp > 0) {
        attackEffect();
        setTimeout(myhpDecrease, 2000);
        setTimeout(changeMyRound, 2500);

    } else {
        clearbossEffect();
    }

}
// 我方回合函式，暫時用不上
function myTurn() {
    let mySelf = document.getElementsByClassName('myRole');
    for (let i = 0; i < myRole.length; i++) {
        mySelf.style.borderColor = "red"
    }
}
//按下去進攻擊階段
function hitBtn() {
    let soundPlay = document.getElementById('mySound');
    //取得按鈕元素
    let btnDisplay = document.getElementById('normalFight');
    //取得上方資訊列
    let topInfoDisplay = document.getElementById('topInfo');
    //點擊按鈕的時候改變按鈕文字
    let mytest = document.getElementById('centerImg');
    //取得HP 顯示區域ID
    let myid2 = document.getElementById('demo2');
    //取得特效區域
    let getBurst = document.getElementById('hitEffect01')
    soundPlay.play();
    //點擊攻擊按鈕時，按鈕文字變為"取消"
    chengeWords();
    //點攻擊按鈕時，根據按鈕文字顯示上方資訊欄
    showTopInfo();
    
    //一次攻擊流程
    if (btnDisplay.innerText == "取消") {
        //設定當攻擊按鈕點擊之後，賦予Boss物件onclick事件，點擊BOSS物件才會觸發後續攻擊行為
        mytest.onclick = function () {
            console.log('BOSS被點擊囉');
            getBurst.setAttribute('src', '../image/hit_03V3.gif');
            setTimeout(clearEffect, 2000);
            setTimeout(damageBOSS, 2000);
            setTimeout(chengeWords, 2400);
            setTimeout(opponentTurn, 3500);
            //當攻擊結束之後，把BOSS物件的onclick事件清空，代表一次攻擊流程完成
            mytest.onclick = null;
           
        }

    } else {
        //當點取消按鈕時，也清空BOSS物件onlcik事件，這樣才不會一直執行
        mytest.onclick = null;
    }

    //攻擊事件完成之後，判斷BOSS血量是否顯示BOSS死亡狀態
    bossDie();

}
//絕學按鈕
function utlBtn() {
    let btnDisplay = document.getElementById('normalFight');
    let btnSpecialDisplay = document.getElementById('specialFight');
    let topInfoDisplay = document.getElementById('topInfo')
    let myWordDivArea = document.getElementById('wordArea')
    //取得BOSS物件ID
    let myBossId = document.getElementById('centerImg');
    //取得HP 顯示區域ID
    let myid2 = document.getElementById('demo2');
    //取得特效區域
    let getBurst = document.getElementById('hitEffect01')
    let showValid = function () {
        getBurst.setAttribute('src', '../image/hit_01V3.gif')
    }
    //放大招的文字(其實是圖檔)
    let utlText = function () {
        //存放四個圖檔的ID名稱
        let myWords = ['word001', 'word002', 'word003', 'word004'];
        //呼叫此函式時要把圖檔顯示的區域放到最上面才不會被蓋住
        myWordDivArea.style.display = 'block';
        myWordDivArea.style.zIndex = 1;
        //迴圈執行，改變style讓隱藏的圖檔顯示，在迴圈中加入setTimeout讓迴圈可以每隔一秒才執行一次
        for (let i = 0; i < myWords.length; i++) {
            let mydemo = document.getElementById(myWords[i]);
            setTimeout(function () {
                document.getElementById(myWords[i]).style.display = "inline-block";
                console.log(i)
            }, 1000 * i)
        }
    }
    //設定大招文字清除
    let utlTextClear = function () {
        let myClearWords = ['word001', 'word002', 'word003', 'word004'];
        //把圖檔顯示文字的區域放到最下層
        myWordDivArea.style.zIndex = '0';
        //隱藏圖檔
        for (let k = 0; k < myClearWords.length; k++) {
            document.getElementById(myClearWords[k]).style.display = 'none';
        }
    }
    soundPlay.play();
    //點擊按鈕的時候改變按鈕文字
    chengeWords();
    showTopInfo();
    //一次攻擊流程
    if (btnSpecialDisplay.innerText == '取消') {
        myBossId.onclick = function () {
            console.log('BOSS被點擊囉');
            getBurst.setAttribute('src', '../image/attackV2.gif')
            setTimeout(showValid, 7300)
            utlText();
            setTimeout(clearEffect, 8800);
            setTimeout(utlTextClear, 6000);
            setTimeout(bigDamage, 8800);
            setTimeout(chengeWords, 2000);
            myBossId.onclick = '';
        }

    } else {
        myBossId.onclick = '';
    }
    bossDie();
}

//顯示上方對話框
function showTopInfo() {
    let topInfoDisplay = document.getElementById('topInfo')
    let btnDisplay = document.getElementById('normalFight');
    let btnSpecialDisplay = document.getElementById('specialFight');
    let myBossId = document.getElementById('centerImg');
    //當涵式被呼叫時會顯示上方對話框
    topInfoDisplay.style.display = 'block';
    //點選物件之後對話框消失
    myBossId.addEventListener('click', function () {
        topInfoDisplay.style.display = 'none';
    }, {
        once: true
    })
    //當按鈕點取消之後上方資訊欄隱藏
    if (btnDisplay.innerText == "攻擊") {
        topInfoDisplay.style.display = 'none';
    } else if (btnSpecialDisplay.innerText == "絕學") {
        topInfoDisplay.style.display = 'none';
    }
}
//改變攻擊、絕學按鈕文字
function chengeWords() {
    let myid = document.getElementById('centerImg');
    let btnDisplay = document.getElementById('normalFight');
    let btnSpecialDisplay = document.getElementById('specialFight');
    //當按鈕點擊時會改變文字顯示
    if (btnDisplay.innerText != '攻擊') {
        btnDisplay.innerText = '攻擊'
        myid.style.cursor = "auto";

    } else {
        btnDisplay.innerText = '取消'
        myid.style.cursor = "pointer";
    }
    if (btnSpecialDisplay.innerText != "絕學") {
        btnSpecialDisplay.innerText = "絕學";
        myid.style.cursor = "auto";
    } else {
        btnSpecialDisplay.innerText = "取消"
        myid.style.cursor = "pointer";
    }

}

//普通攻擊
function damageBOSS() {
    let mydamage = Math.floor(Math.random() * 1000);
    let bossHp = bossObjCenter.hp;
    let demoInfo = document.getElementById('demo1');
    let mydemo1 = document.getElementById('demo2');
    let hpfly = document.getElementById('hpEffect');
    let hpflyFunc = function () {
        hpfly.innerText = '';
    }
    bossObjCenter.hp = bossHp - mydamage;
    if (bossObjCenter.hp <= 0) {
        bossObjCenter.hp = 0;
        mydemo1.innerText = `施展普通劍法對魔尊造成 ${mydamage} 點傷害，當前HP : ${bossObjCenter.hp}，BOSS死亡`
        hpfly.innerText = '-' + mydamage;
        setTimeout(hpflyFunc, 1000);
        bossDie();
    } else {
        mydemo1.innerText = `施展普通劍法對魔尊造成 ${mydamage} 點傷害`;
        hpfly.innerText = '-' + mydamage;
        setTimeout(hpflyFunc, 1000);
        demoInfo.innerText = '對手回合';
    }
}
//施展絕學
function bigDamage() {
    mydamage = Math.floor(Math.random() * 100000);
    let bossHp = bossObjCenter.hp;
    let mydemo1 = document.getElementById('demo2');
    bossObjCenter.hp = bossHp - mydamage;
    let hpfly = document.getElementById('hpEffect');
    let hpflyFunc = function () {
        hpfly.innerText = '';
    }
    if (bossObjCenter.hp <= 0) {
        bossObjCenter.hp = 0;
        mydemo1.innerText = `施展絕學-萬劍歸一，對魔尊造成 ${mydamage} 點傷害，魔尊死亡`
        hpfly.style.fontSize = '50px';
        hpfly.innerText = '-' + mydamage;
        setTimeout(hpflyFunc, 1000);
        bossDie();
    } else {
        mydemo1.innerText = `對魔尊造成 ${mydamage} 傷害`;
        hpfly.innerText = '-' + mydamage;
        setTimeout(hpflyFunc, 1000);
    }
}

//當hp = 0時，添加動畫
function bossDie() {
    let bossImg = document.getElementById('centerImg');
    let winImg = document.getElementById('winGame');
    let winImgArea = document.getElementById('winGameArea');
    let bosshp = bossObjCenter.hp;
    //先取得class屬性
    let classVal = bossImg.getAttribute("class");
    let classVal_A = winImg.getAttribute("class");
    //設定一個函數當hp歸零時圖會消失
    let bosshidden = function () {
        bossImg.setAttribute('src', '');
    }
    let winGameMsgShow = function () {
        // winImgArea.style.display="block";
        winImg.setAttribute('src', '../image/paperV2.png');
        winImgArea.style.zIndex = '1';
    }
    //連接各class屬性
    classVal01 = classVal.concat('animated ld ld-fade');
    classVal02 = classVal_A.concat('animaanimated ld ld-wander-v');

    // 當hp歸零時，使用動畫
    if (bossObjCenter.hp <= 0) {
        //先出現動畫，2秒後圖消失
        bossImg.setAttribute('class', classVal01);
        winImg.setAttribute('class', classVal02);
        setTimeout(bosshidden, 2000);
        setTimeout(winGameMsgShow, 3000);
    }

}

function goodEndFunc() {
    location.href = "goodEndPage.html";
}
//陰陽圖示按鈕隱藏其他按鈕功能
function showBtn() {
    let btnArr = ['normalFight', 'myObj', 'specialFight', 'run']
    let hideBtn = function () {
        for (let i = 0; i < btnArr.length; i++) {
            document.getElementById(btnArr[i]).style.display = "none";
        }
    }
    let showMeBtn = function () {
        for (let j = 0; j < btnArr.length; j++) {
            document.getElementById(btnArr[j]).style.display = "block";
        }
    }
    if (document.getElementById(btnArr[0]).style.display == "none") {
        showMeBtn();
    } else {
        hideBtn();
    }
}

//逃跑鍵功能
function runBtn() {
    soundPlay.play();
    let mydemo = document.getElementById("demo4");
    let runArr = ['身為大俠怎可逃跑...!', '躲不掉的，乖乖戰鬥吧...!', '死一次不夠，那還不死個第二次...!', '打贏BOSS有時不只要靠賽，更要靠腦袋...!', '好絕學不用一下嗎....?']
    mydemo.innerText = runArr[Math.floor(Math.random() * 5)];
}
//物品鍵功能
function myObjBtn() {
    soundPlay.play();
    let mySound = function(){
        document.getElementById('myObj').addEventListener()
    }
    let mydemo = document.getElementById("demo4");
    let myObjArr = ['打王用暗器非是大俠行為...!', '吃補藥補生命不如先補自己的腦子...!', '死一次不夠，那還不死個第二次...!', '知恥近乎勇，但你看起來不太勇...?', '想要物品欄，先去商城儲個一單....']
    mydemo.innerText = myObjArr[Math.floor(Math.random() * 5)];
}
 // 播音樂，因為chrome阻擋自動撥放，因此使用點擊事件點網頁本身撥放
let myAudio = document.getElementById('myMusic');
console.log(myAudio);
window.document.body.addEventListener('click', function () {
    myAudio.play();
})