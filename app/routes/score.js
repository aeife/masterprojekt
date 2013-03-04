/*
 * # score.js
 *
 * Router zur Verwaltung des Highscores und Spielarchivs
 */

/*
 * ## exports.list
 *
 * Rendern des Templates zur Anzeige einer Liste aller vorherigen Spiele
 */
exports.list = function(req, res){

    // Datenbankinformationen einbinden
    var db = require('../database.js');

    db.init(function(err, db) {
        if(err) throw err;

        var collection = db.collection('game');

        // Finden aller verschiedenen Spiel-IDs
        collection.distinct('id', function (err, games){
            if(err) throw err;
            
            // alle gefundenen Spiele dem Template übergeben
            if (games){
                console.log(games);
                res.render('score', {games: games, username: req.session.username});
            }

        });

    });
    
};

/*
 * ## exports.details
 *
 * Rendern des Templates zur Anzeige des Ergebnisses eines Spiels
 */
exports.details = function(req, res){

    // Datenbankinformationen einbinden
    var db = require('../database.js');

    db.init(function(err, db) {
        if(err) throw err;

        var collection = db.collection('game');

        // Finden aller am Spiel teilgenommenen Spieler, sortiert nach ihrer Platzierung
        collection.find({id: parseInt(req.params.id)}, {'sort': {place: 1}}).toArray(function(err, items) {
            if(err) throw err;
            
            // Übergabe aller Informationen an das Template
            if (items){
                console.log(items);
                res.render('scoreDetails', {games: items, username: req.session.username});
            }
        });

    });
    
};

/*
 * ## exports.players
 *
 * Rendern des Templates zur Anzeige des Spieler-Highscores
 */
exports.players = function(req, res){
    //  Datenbankinformationen einbinden
    var db = require('../database.js');

    db.init(function(err, db) {
        if(err) throw err;

        var collection = db.collection('game');

        // Finden aller verschiedenen Nutzer
        collection.distinct('username', function (err, users){
            if(err) throw err;
            
            // Für jeden gefundenen Nutzer Berechnung seiner Punkte
            if (users){

                users.splice(users.indexOf('Guest'), 1);
                users.sort();

                var players = [];
                for (var i = 0; i < users.length; i++){
                    players[i] = {username: users[i], score: 0};
                }

                // Sortierung aller Einträge nach Nutzernamen, Gäste ausgeschlossen
                collection.find({username: {$ne: 'Guest'}}, {'sort': {username: 1}}).toArray(function(err, items) {
                    if(err) throw err;

                    if (items){
                        var j = 0;
                        for (var i = 0; i < players.length; i++){
                            
                            while (j < items.length && players[i].username === items[j].username){

                                switch (items[j].place){
                                    case 1:
                                        players[i].score += 50;
                                        break;
                                    case 2:
                                        players[i].score += 25;
                                        break;
                                    case 3:
                                        players[i].score += 10;
                                        break;
                                    case 4:
                                        players[i].score += 5;
                                        break;
                                }
                                j++;
                            }
                        }

                        players.sort(function(a,b){
                            if(a.score < b.score) return 1;
                            if(a.score > b.score) return -1;
                            return 0;
                        });
                        
                        res.render('scorePlayers', { title: 'Express', players: players, username: req.session.username});
                    }
                });

            }

        });
        

    });
    
};