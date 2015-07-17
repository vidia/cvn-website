module.exports = function(app) {

	if (!app.http) {
		throw new Error("Express was not attached as 'http'");
	}

	require("./user")(app);
}
