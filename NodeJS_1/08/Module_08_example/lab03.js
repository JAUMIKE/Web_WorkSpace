const fs=require('fs')
const car={
  name:'BMW',
  speed:100
}
const carStr=JSON.stringify(car)
fs.writeFileSync('./car.json',carStr,{encoding:'utf-8'})