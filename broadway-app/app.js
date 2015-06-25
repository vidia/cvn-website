var broadway = require('broadway'),
    app = new broadway.App();

//Attach the http handler and it's routes. 
app.use(require('./http'));

//Attach the model (ORM, schemas, object functions)



app.init(function(err) {
    app.http.listen(8080);
});