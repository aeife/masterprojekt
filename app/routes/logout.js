/*
 * # logout.js
 *
 * Router zur Verwaltung des Logouts
 */

/*
 * ## exports.logout
 *
 * Löschen der Session und Weiterleitung zur Startseite
 */
exports.logout = function(req, res){
    req.session.destroy();

    res.redirect('/');
};