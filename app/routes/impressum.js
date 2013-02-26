
/*
 * GET impressum page.
 */

exports.impressum = function(req, res){
  res.render('impressum', { title: 'Express', username: req.session.username });
};