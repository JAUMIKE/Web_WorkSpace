//1.	請補齊程式碼，讓程式可以console.log出{ test1: [Function: test2] }。
const test1 = function () {
  const test2 = function () {
    setTimeout(() => {
      console.log(this); 
    }, 100);
  };
  const test3={
    test1:test2
  }
  test3.test1(); 
}
test1(); 