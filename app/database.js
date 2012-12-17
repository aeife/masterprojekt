var database;

module.exports = {

    init : function(cb) {
        var MongoClient = require('mongodb').MongoClient;
        MongoClient.connect("mongodb://localhost:27017/masterprojekt", cb);
    }
};