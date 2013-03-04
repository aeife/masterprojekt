/*
 * # login.js
 *
 * Router zur Verwaltung des Logins
 */

/*
 * ## exports.form
 *
 * Rendern des Templates zur Anzeige des Loginbereichs
 */
exports.form = function(req, res){
    res.render('login');
};

/*
 * ## exports.auth
 *
 * Authorisierung eines Loginversuchs
 */
exports.auth = function(req, res){
    
    // Datenbankinformationen einbinden
    var db = require('../database.js');

    db.init(function(err, db) {
        if(err) throw err;

        var collection = db.collection('user');

        var username = req.body.name;

        // Verschlüsselung des Passworts mittels MD5
        var password = require('crypto').createHash('md5').update(req.body.password).digest("hex");

        // Nach Nutzer mit Logininformationen suchen
        collection.findOne({username: username, password: password}, function (err, users){
            if(err) throw err;
            
            // Wenn Nutzer gefunden wurde, Nutzernamen in Session eintragen
            if (users){
                req.session.username = username;
            }


            // Weiterleitung zur Startseite
            res.redirect('/');
        });

    });

    
};