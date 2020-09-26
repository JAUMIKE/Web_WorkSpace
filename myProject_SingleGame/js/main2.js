      // 3. 取得 #mainRole 這個元素
      var myRole = document.getElementById('mainRole');
      // 判斷圖片次數
      let checkWordsNum = 0;
      // 判斷對話次數變數
      let checkImgNum = 0;

      function movemainRole(evt) {
          //取得圖片全部樣式存入allStyle
          var allStyle = window.getComputedStyle(myRole);
          //取得圖片left的樣式
          var elmLeft = allStyle.getPropertyValue('left');
          var elmTop = allStyle.getPropertyValue('top');
          switch (evt.keyCode) {
              case 37:
                  myRole.style.left = (parseInt(elmLeft) - 10) + 'px';
                  myRole.style.transform = 'scaleX(-1)';
                  break;
                  // case 38:
                  //     myRole.style.top = (parseInt(elmTop) - 10) + 'px';
                  //     // myRole.style.transform = 'scaleY(1)';
                  //     break;
              case 39:
                  // 卡波往右邊移動，依目前位置+10px
                  myRole.style.transform = 'scaleX(1)';
                  myRole.style.left = (parseInt(elmLeft) + 10) + 'px';

                  break;
                  // case 40:

                  //     myRole.style.top = (parseInt(elmTop) + 10) + 'px';
                  //     // myRole.style.transform = 'scaleY(-1)';
                  //     break;
          }
      }

      function showMsg() {
          myMsg = document.getElementById('topMidAreaNextId');
          myMsg.style.display = 'grid';
          changeWords();

      }

      function changePage() {
          location.href = "battle_update.html"
      }

      function changeImg() {
          let myImg = ['../image/anotherrole01V2.png', '../image/BOSS_head.png'];
          takeImg = document.getElementById('talkImg');
          if (checkImgNum < myImg.length) {
              takeImg.setAttribute('src', `${myImg[checkImgNum]}`);
              checkImgNum += 1;
          } else {
              checkImgNum = 0;
              takeImg.setAttribute('src', `${myImg[checkImgNum]}`);
              checkImgNum += 1;
          }
      }
      //依照myWords陣列存取的長度來判斷要換幾次文字
      function changeWords() {
          let myWords = ['魔尊 ， 今日之戰 ， 只能有一方離開 ! 話說...你的畫風跟我也差太多了吧 !?', '柳雲英，除掉你，天底下我再無對手，下一步就是滅掉其他三大派了 ! 還有 ， 我是BOSS ， 畫風給點VIP待遇也是理所當然的 !', '從一開始就佔盡優勢 ， 雖說是魔尊，還是挺卑鄙的阿', '少廢話 來戰吧!']
          let takeWords = document.getElementById('talkWords');
          if (checkWordsNum < myWords.length) {
              takeWords.innerHTML = myWords[checkWordsNum];
              checkWordsNum += 1;
              changeImg()
          } else {
              changePage();
          }

      }
      // 播音樂，因為chrome阻擋自動撥放，因此使用點擊事件點網頁本身撥放
      let myAudio = document.getElementById('myMusic');
      window.document.body.addEventListener('click', function () {
          myAudio.play();
      })