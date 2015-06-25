var express = require('express');

exports.name = 'http';

exports.attach = function(options) {
    var app = this;

    var server = app.http = express();
    server.use(server.router);

    require('./routes')(app);
};

exports.init = function(done) {
    done();
};