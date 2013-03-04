/*
 * # impressum.js
 *
 * Router zur Verwaltung des Impressums
 */

/*
 * ## exports.impressum
 *
 * Rendern des Templates zur Anzeige des Impressums und Übergabe des aktuellen Nutzernamens aus der Session
 */
exports.impressum = function(req, res){
  res.render('impressum', {username: req.session.username });
};