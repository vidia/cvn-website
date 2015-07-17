module.exports = function setup(options, imports, register) {
    var app = this;

    var Sequelize = require("sequelize");
    var sequelize = new Sequelize(
    	"cvn_main", "testuser", "Saphira123", {
    		dialect: "mysql",
    		host: "wyx1haa8fc.database.windows.net",
    		port: 1433
    	});

    //routes/index.js runs a require against all routes
    var Attendance = sequelize.import(__dirname + "/attendance");
    var AttendanceType = sequelize.import(__dirname + "/attendanceType");
    var Message = sequelize.import(__dirname + "/message");
    var Season = sequelize.import(__dirname + "/season");
    var Setting = sequelize.import(__dirname + "/setting");
    var Show = sequelize.import(__dirname + "/show");
    var User = sequelize.import(__dirname + "/user");

    debugger;
    register(null, {
        user: User, 
        attendance: Attendance
    })
};
