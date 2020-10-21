const express = require('express');
const router = express.Router();
const students=require('../students.json')

/* GET home page. */
router.get('/', function(req, res, next) {
  console.log(students);
  res.render('index', { title:'Express',students });
});

module.exports = router;
