exports.logout = function(req, res){
    req.session.destroy();
    res.render('index', { title: 'Express'});
};