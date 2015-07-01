
exports.name = 'model';

exports.attach = function(options) {
    var app = this;

    var server = app.http = express();
    server.use(server.router);

    //TODO: Add error handling here. 
    //Maybe add a component to look up error codes


    //routes/index.js runs a require against all routes
    require('./user')(app);
};

exports.init = function(done) {
    done();
};