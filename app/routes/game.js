/*
 * # game.js
 *
 * Router zur Verwaltung des Spiels
 */

/*
 * ## exports.game
 *
 * Rendern des Templates zur Anzeige des Spiels und Pbergabe des Nutzernamens aus der Session
 */
exports.game = function(req, res){
  res.render('game', {username: req.session.username});
};