var express = require('express');
var path = require("path");
var bodyParser = require("body-parser");
var morgan = require('morgan');
var session = require("express-session");
var cookieParser = require("cookie-parser");
var flash    = require('connect-flash');
var logger = require('./logger');
var auth = require("./auth"); //passport auth with some helper functions.
var MySQLStore = require('connect-mysql')(session);
var app = express();
var models = require("./models");

models.init(function() {
    logger.info("Models loaded");
});

app.use(morgan("dev"));
app.set("views", path.join(__dirname, './view'));
app.set("view engine", "jade");
app.use(bodyParser.urlencoded({
    extended: true
}));
app.use(bodyParser.json());
app.use(session({
    secret: "sdfgbsthnrtbtsdfhthaerhnrdsfhbtranet5",
    saveUninitialized: true,
    resave: true,
    store: new MySQLStore({config: require("./config").databaseUri})
}));
app.use(flash());
//Attaches passport and initializes.
auth.attach(app);

//statics
app.use("/dist", express.static(path.join(__dirname, "../public")));
app.use("/bower_components", express.static(path.join(__dirname, "../bower_components")));

//routes/index.js runs a require against all routes
require('./routes')(app); //TODO: should change to using a router.

//TODO: Add an event listen for the models to init. Send event in models. 
app.listen(process.env.PORT || 3000, function(err) {
    if(err) {
        logger.error(err);
    } else {
        logger.info("Listening on port 3000");
    }
});
