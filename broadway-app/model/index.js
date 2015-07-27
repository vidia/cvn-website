module.exports = function setup(options, imports, register) {
    imports.logger.info("Loading models plugin"); 

    var app = this;

    var Sequelize = require("sequelize");
    var sequelize = new Sequelize(require("../config/database")());

    var Attendance = sequelize.import(__dirname + "/attendance");
    //var AttendanceType = sequelize.import(__dirname + "/attendanceType");
    //var Message = sequelize.import(__dirname + "/message");
    //var Season = sequelize.import(__dirname + "/season");
    //var Setting = sequelize.import(__dirname + "/setting");
    //var Show = sequelize.import(__dirname + "/show");
    var User = sequelize.import(__dirname + "/user");


    User.sync().then(function () {
        imports.logger.info("Database connected"); 
        // Table created
        register(null, {
            user: User, 
            attendance: Attendance
        })
    });

    
};
