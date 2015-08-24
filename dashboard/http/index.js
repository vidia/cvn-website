var express = require('express');
var path = require("path")
var bodyParser = require("body-parser"); 
var morgan = require('morgan')
var session = require("express-session"); 
var cookieParser = require("cookie-parser"); 
var flash    = require('connect-flash');

var MySQLStore = require('connect-mysql')(session);

module.exports = function setup(options, imports, register) {
    imports.logger.info("Loading http plugin"); 
    var app = this;

    var server = app.http = express();
    server.use(morgan("dev")); 
    server.set("views",  path.join(__dirname, '../view'))    
    server.set("view engine", "jade");
    server.use(bodyParser.urlencoded({
        extended: true
    }));
    server.use(bodyParser.json());
    server.use(session({
        secret: "sdfgbsthnrtbtsdfhthaerhnrdsfhbtranet5",
        saveUninitialized: true,
        resave: true, 
        store: new MySQLStore({config: require("../config/database")()})
    })); 
    server.use(flash()); 


    //statics 
    server.use("/dist", express.static(path.join(__dirname, "public"))); 
    server.use("/bower_components", express.static(path.join(__dirname, "../bower_components"))); 

    //TODO: Add error handling here.
    //Maybe add a component to look up error codes

    imports.auth.attach(server); 

    //routes/index.js runs a require against all routes
    require('./routes')(app, imports);

    server.listen(3000, function(err) {
    	imports.logger.info("Listening on port 3000"); 
    }); 
}

