var express = require('express');

exports.name = 'http';

exports.attach = function(options) {
    var app = this;

    var server = app.http = express();
    server.use(server.router);
    server.set("view engine", "jade");
    //TODO: Add error handling here.
    //Maybe add a component to look up error codes


    //routes/index.js runs a require against all routes
    require('./routes')(app);
};

exports.init = function(done) {
    done();
}
