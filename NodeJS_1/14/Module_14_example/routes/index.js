const express = require('express');
const router = express.Router();
const url = require('url');

/* GET home page. */
router.get('/', function(req, res, next) {
  const urlObj={
    query:{
      type:'shoes'
    }
  }
  const newUrl=url.format(urlObj);
  res.redirect(`/merchandises${newUrl}`);
});

router.get('/merchandises', function(req, res, next) {
  console.log(req.query);//{ type: 'shoes' }
  res.json({
    total:2,
    list:[
      {
        name:'NIKE'
      },
      {
        name:'PUMA'
      }
    ]
  })
});

module.exports = router;
