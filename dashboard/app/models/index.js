var logger = require("../logger");
var Sequelize = require("sequelize");
var sequelize = new Sequelize(require("../config").databaseUri);

var Attendance = sequelize.import("attendance", require("./attendance"));
var AttendanceType = sequelize.import("attendanceType", require("./attendanceType"));
//var Message = sequelize.import(__dirname + "/message");
var Season = sequelize.import("season", require("./season"));
var Setting = sequelize.import("setting", require("./setting"));
var Event = sequelize.import("event", require("./event"));
var User = sequelize.import("user", require("./user"));

Attendance.belongsTo(User);
Attendance.belongsTo(Event);
Attendance.belongsTo(AttendanceType);

// Attendance.afterCreate("updatePointsHook", function(attendance, options) {
    
// }); 

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