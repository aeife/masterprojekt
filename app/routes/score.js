
exports.list = function(req, res){

    //require database connection
    var db = require('../database.js');

    //init database
    db.init(function(err, db) {
        if(err) throw err;

        //select table of db
        var collection = db.collection('game');

        //find one and only user with credentials
        collection.distinct('id', function (err, games){
            if(err) throw err;
            
            //if user is found, write username in session
            if (games){
                console.log(games);
                res.render('score', { title: 'Express', games: games});
            }

        });

    });
    
};

exports.details = function(req, res){

    //require database connection
    var db = require('../database.js');

    //init database
    db.init(function(err, db) {
        if(err) throw err;

        //select table of db
        var collection = db.collection('game');

        //find one and only user with credentials
        collection.find({id: parseInt(req.params.id)}, {'sort': {place: 1}}).toArray(function(err, items) {
            if(err) throw err;
            
            //if user is found, write username in session
            if (items){
                console.log(items);
                res.render('scoreDetails', { title: 'Express', games: items});
            }
        });

    });
    
};

exports.players = function(req, res){
    //require database connection
    var db = require('../database.js');

    //init database
    db.init(function(err, db) {
        if(err) throw err;

        //select table of db
        var collection = db.collection('game');

        collection.distinct('username', function (err, users){
            if(err) throw err;
            
            //if user is found, write username in session
            if (users){

                users.splice(users.indexOf('Guest'), 1);
                users.sort();

                var players = [];
                for (var i = 0; i < users.length; i++){
                    players[i] = {username: users[i], score: 0};
                }

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
                        
                        res.render('scorePlayers', { title: 'Express', players: players});
                    }
                });

            }

        });
        

    });
    
};