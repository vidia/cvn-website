module.exports = function setup(options, imports, register) {
    imports.logger.info("Loading models plugin"); 

    var app = this;

    var Sequelize = require("sequelize");
    /*var sequelize = new Sequelize(
    	"cvn_main", "testuser@wyx1haa8fc", "Saphira123", {
    		dialect: "mysql",
    		host: "wyx1haa8fc.database.windows.net",
    		port: 1433
    	});
*/
var sequelize = new Sequelize("mysql://testuser:Saphira123@wyx1haa8fc.database.windows.net:1433/cvn_main");
    imports.logger.error("Need to connect to the server."); 

    //routes/index.js runs a require against all routes
    var Attendance = sequelize.import(__dirname + "/attendance");
    //var AttendanceType = sequelize.import(__dirname + "/attendanceType");
    //var Message = sequelize.import(__dirname + "/message");
    //var Season = sequelize.import(__dirname + "/season");
    //var Setting = sequelize.import(__dirname + "/setting");
    //var Show = sequelize.import(__dirname + "/show");
    var User = sequelize.import(__dirname + "/user");


    User.sync({force: true}).then(function () {
        imports.logger.info("Database connected"); 
        // Table created
        register(null, {
            user: User, 
            attendance: Attendance
        })
    });

    
};
