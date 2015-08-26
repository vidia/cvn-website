module.exports = function(app, imports) {

	if (!app.http) {
		throw new Error("Express was not attached as 'http'");
	}

	require("./user")(app.http, imports);
	require("./dashboard")(app.http, imports);
	require("./event")(app.http, imports);
	require("./attendance")(app.http, imports); 
	require("./season")(app.http, imports); 
}
