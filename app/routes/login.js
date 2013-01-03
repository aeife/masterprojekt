
exports.form = function(req, res){
    res.render('login', { title: 'Express'});
};

exports.auth = function(req, res){
    
    //require database connection
    var db = require('../database.js');

    //init database
    db.init(function(err, db) {
        if(err) throw err;

        //select table of db
        var collection = db.collection('user');

        //get params from html form
        var username = req.body.name;
        //create md5
        var password = require('crypto').createHash('md5').update(req.body.password).digest("hex");

        //find one and only user with credentials
        collection.findOne({username: username, password: password}, function (err, users){
            if(err) throw err;
            
            //if user is found, write username in session
            if (users){
                req.session.username = username;
            }


            //redirect
            res.redirect('/game');
        });

    });

    
};