/*
 * # register.js
 *
 * Router zur Verwaltung der Registrierung
 */

/*
 * ## exports.form
 *
 * Rendern des Templates zur Anzeige des Registrierungsformulars
 */
exports.form = function(req, res){
    res.render('register', {error: null, username: req.session.username});
};

/*
 * ## exports.regiter
 *
 * Prüfen der Angabe und ggf. Registrierung
 */
exports.register = function(req, res){
    if (req.body.password != req.body.passwordRepeat){
        // Prüfe, ob eingegebene Passwörter gleich sind
       res.render('register', {error: "Passwörter stimmen nicht überein", username: req.session.username}); 
    } else if (req.body.password.length < 5){
        // Prüfe, ob Passwort Mindestlänge erfüllt
       res.render('register', {error: "Passwort ist zu kurz (mindestens 5 Zeichen)", username: req.session.username});
    } else {
        // Prüfe, ob gewählter Nutzername schon vorhanden ist

        // Einbinden der Datenbankinformationen
        var db = require('../database.js');

        db.init(function(err, db) {
            if(err) throw err;

            var collection = db.collection('user');

            var username = req.body.name;
            // Verschlüsselung des Passworts mittels MD5
            var password = require('crypto').createHash('md5').update(req.body.password).digest("hex");

            collection.findOne({username: username}, function (err, users){
                if(err) throw err;
                
                if (users){
                    // Nutzername bereits vorhanden, Anzeige des Fehlers
                    res.render('register', {error: "Nutzername existiert bereits", username: req.session.username}); 
                } else {
                    // Füge einen neuen Nutzer hinzu
                    collection.insert({username: username, password: password}, {w:1}, function(err, result) {
                        if (err) throw err;
                        res.redirect('/');
                    });
                }
            });
        });
    }

};