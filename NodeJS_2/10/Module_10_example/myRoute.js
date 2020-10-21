
const express = require('express');
const router = express.Router();
router.get('/', function (req, res) {
  res.send('homepage');
});
router.get('/today', function (req, res) {
  console.log('Time(today): ' + Date());
  res.send('One apple a day');
});
router.get('/doctor', function (req, res) {
  res.send('no doctor');
});
module.exports = router;

