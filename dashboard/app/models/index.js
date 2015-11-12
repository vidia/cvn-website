var logger = require("../logger");
var Sequelize = require("sequelize");
var sequelize = new Sequelize(require("../config").databaseUri);

var Attendance = sequelize.import(__dirname + "/attendance");
var AttendanceType = sequelize.import(__dirname + "/attendanceType");
//var Message = sequelize.import(__dirname + "/message");
var Season = sequelize.import(__dirname + "/season");
var Setting = sequelize.import(__dirname + "/setting");
var Event = sequelize.import(__dirname + "/event");
var User = sequelize.import(__dirname + "/user");

Attendance.belongsTo(User);
Attendance.belongsTo(Event);
Attendance.belongsTo(AttendanceType);

User.hasMany(Attendance, {as: "Attendances"});
Event.hasMany(Attendance, {as: "Attendances"});

Event.belongsTo(Season);

module.exports = {
    user: User,
    attendance: Attendance,
    attendanceType: AttendanceType,
    event: Event,
    settings: Setting,
    season: Season
};
module.exports.init = function (callback) {
    sequelize.sync({force:false}).then(function () {
        logger.info("Database connected");
        if (callback) {
            callback();
        }
    });
};