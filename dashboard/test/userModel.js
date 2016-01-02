var model = require("../app/models"); 
var should = require("should"); 
var async = require("async"); 

describe("Models", function() {
    describe("User", function() {
        before(function(done) {
            this.timeout(10000);
            async.waterfall([
                function(callback) {
                    model.init(function() {
                        callback()
                    });
                },
                function(callback) {
                    model.user.findOrCreate({
                        where: {
                            email: "dmtschida1@gmail.com",
                            password: "foo",
                            name: "David Tschida"
                        }
                    })
                    .then(function(user) {
                        callback(null, user[0]);
                    })
                },
                function(user, callback) {
                    var eventData = [
                        { name: "A cool event", points: 11 }, 
                        { name: "A better event", points: 13 }, 
                        { name: "An awesome event", points: 15 }
                    ]; 
                    async.map(eventData, function(data, cb) {
                        model.event.findOrCreate({
                            where: {
                                name: data.name,
                                pointValue: data.points
                            }
                        })
                        .then(function(event) {
                            event = event[0]; 
                            cb(null, event); 
                        });
                    }, 
                    function(err, events) {
                        callback(err, events, user)
                    });
                }, 
                function(results, user, callback) {
                   model.attendanceType.getAllDefaultTypes(function(err, types) {
                       callback(err, results, user, types)
                   }); 
                }, 
                function(results, user, types, callback) {
                    async.each(results, function(event, callback) {
                        model.attendance.findOrCreate({
                            where: {
                                UserUuid : user.uuid,
                                EventUuid: event.uuid
                            }
                        })
                        .then(function(attendance) {
                            attendance = attendance[0]; 
                            attendance.AttendanceTypeUuid = types.presentType.uuid;
                            if(attendance.changed("AttendanceTypeUuid")) {
                                attendance.save()
                                .then(function() {
                                    callback(); 
                                });
                            }
                        });
                    }, callback);
                },
                function() {
                    done(); 
                }
            ]);
        });
        
        it("should query by email", function(done) {
            this.timeout(1000);
            model.user.findOne({where: {email : "dmtschida1@gmail.com"}})
            .then(function(user) {
                should(user).be.ok(); 
                user.email.should.equal("dmtschida1@gmail.com"); 
                user.name.should.equal("David Tschida");
                user.uuid.should.not.equal(null); 
                done();
            });
        });
        it("should check it's password", function(done) {
            //TODO: Make this not hit the db
            this.timeout(10000);
            model.user.findOne({where: {email : "dmtschida1@gmail.com"}})
            .then(function(user) {
                user.checkPassword("foo").should.equal(true); 
                user.checkPassword("bar").should.equal(false); 
                done(); 
            });
        });
        it("should calculate it's points properly when present for all events", function(done) {
            this.timeout(5000); 
            async.waterfall([
                function(callback) {
                    model.user.findOne({where: {email : "dmtschida1@gmail.com"}})
                    .then(function(user) {
                        should.exist(user);
                        callback(null, user);
                    });
                }, 
                function(user, callback) {
                    user.getPoints(callback);
                }, 
                function(points, callback) {
                    should.exist(points)
                    points.should.be.a.Number(); 
                    points.should.equal(39); 
                }
            ], function(err, result) {
                done(); 
            });
        });
    });
});