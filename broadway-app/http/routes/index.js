module.exports = function(app, imports) {

	if (!app.http) {
		throw new Error("Express was not attached as 'http'");
	}

	require("./user")(app.http, imports);
}
