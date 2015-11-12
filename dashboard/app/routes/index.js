module.exports = function(app) {

	if (!app) {
		throw new Error("No app given");
	}

	require("./user")(app);
	require("./dashboard")(app);
	require("./event")(app);
	require("./attendance")(app);
	require("./season")(app);
}
