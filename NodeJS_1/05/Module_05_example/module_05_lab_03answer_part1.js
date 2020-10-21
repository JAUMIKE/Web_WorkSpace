//3.	承上題，請將類別輸出成一個module，另請新增另外一個js 檔案，引用該module。
class Me {
  constructor(firstName, lastName) {
    this.name = 'Michael';
    this.age = 28;
  }

  say() {
    console.log('Hi! I am ' + this.name)
  }
}
module.exports = Me