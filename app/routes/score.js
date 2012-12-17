
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