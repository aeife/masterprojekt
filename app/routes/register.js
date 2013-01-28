exports.form = function(req, res){
    res.render('register', {error: null});
};

exports.register = function(req, res){
    if (req.body.password != req.body.passwordRepeat){
        // Prüfe, ob eingegebene Passwörter gleich sind
       res.render('register', {error: "password"}); 
    } else if (req.body.password.length < 5){
        // Prüfe, ob Password Mindestlänge erfüllt
       res.render('register', {error: "passwordLength"});
    } else {
        // Prüfe ob gewählter Nutzername schon vorhanden ist

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
            collection.findOne({username: username}, function (err, users){
                if(err) throw err;
                
                //if user is found, write username in session
                if (users){
                    // Nutzername bereits vorhanden
                    res.render('register', {error: "username"}); 
                } else {
                    // Füge einen neuen Nutzer hinzu
                    collection.insert({username: username, password: password}, {w:1}, function(err, result) {
                        if (err) throw err;
                        res.redirect('/login');
                    });
                }
            });
        });
    }

};