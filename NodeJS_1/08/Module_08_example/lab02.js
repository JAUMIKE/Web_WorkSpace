const fs=require('fs')
fs.writeFile('./fs_async.txt','hello async world',{encoding:'utf-8'},(e)=>{
  if(e){
    console.error(e)
  }
  fs.readFile('./fs_async.txt',{encoding:'utf-8'},(e,data)=>{
    if(e){
      console.error(e)
    }
    console.log(data)
  })
});