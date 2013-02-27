exports.logout = function(req, res){
    req.session.destroy();
    //redirect
    res.redirect('/');
};