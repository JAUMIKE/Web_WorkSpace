function openwin() {
    let dftWidth=500;
    let dftHeight=500;
    let w=window.screen.width/2-(dftWidth/2);
    let t=window.screen.height/2-(dftHeight/2)-35;
    window.open ("login.php", 
                    "newwindow", 
                    "height="+dftHeight+", width="+dftWidth+", toolbar=no, menubar=no, scrollbars=no, resizable=no, location=no, status=no,left="+w+",top="+t);
    }

