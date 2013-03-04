/*
 * # index.js
 *
 * Router zur Verwaltung der Startseite
 */

/*
 * ## exports.index
 *
 * Rendern des Templates zur Anzeige der Startseite und Übergabe des aktuellen Nutzernamens aus der Session
 */
exports.index = function(req, res){
  res.render('index', {username: req.session.username });
};