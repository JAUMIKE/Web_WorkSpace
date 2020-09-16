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
         function changePage(){
             location.href = "main2.html"
         }

        function changeImg() { 
            let myImg=['../image/anotherrole01V2.png','../image/anotherrole02V1.png'];
            takeImg = document.getElementById('talkImg');
            if(checkImgNum < myImg.length){
                takeImg.setAttribute('src',`${myImg[checkImgNum]}`);
                checkImgNum+=1;    
            }else{
                checkImgNum =0;
                takeImg.setAttribute('src',`${myImg[checkImgNum]}`);
                checkImgNum+=1; 
            }      
         }
         //依照myWords陣列存取的長度來判斷要換幾次文字
         function changeWords() {
            let myWords = ['紀姑娘的歌聲依然如此動人呢....','雲英大哥，江湖傳聞你與魔君將一決生死，此事是否當真?','確實如此， 此戰極度凶險 ， 此次前來別過，也是想再見姑娘一面，有緣的話還能再會，若無緣....還望姑娘珍重!',
             '魔君實力高深莫測，我跟著你去也是拖累你，雲英大哥多加小心，我會在這裡天天守著你回來的。','若等了太久，就別等了...','不會的，我相信我等的人不會讓我失望! 所以....雲英，請你一定要回來!','子嫣......承君此諾，必守一生']
            let takeWords = document.getElementById('talkWords');
            if(checkWordsNum < myWords.length){
                takeWords.innerText = myWords[checkWordsNum];
                checkWordsNum +=1;
                changeImg()
            }else{
                changePage();
            }
            
         }
       

