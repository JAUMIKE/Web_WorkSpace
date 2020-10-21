const fs=require('fs')
fs.writeFileSync('./fs_sync.txt','hello sync world',{encoding:'utf-8'});
const data= fs.readFileSync('./fs_sync.txt',{encoding:'utf-8'});
console.log(data)