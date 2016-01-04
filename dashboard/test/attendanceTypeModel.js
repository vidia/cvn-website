var model = require("../app/models"); 
var should = require("should"); 
var async = require("async"); 

describe("Models", function() {
    describe("AttendanceType", function() {
        before(function(done) {
            this.timeout(10000);
            async.waterfall([
                function(callback) {
                    model.init(function() {
                        callback()
                    });
                }
            ], 
            function() {
                done(); 
            }); 
        });
        
        it("should return all default types", function(done) {
            this.timeout(5000);
            async.waterfall([
                function(callback) {
                    model.attendanceType.getAllDefaultTypes(callback)
                }, 
                function(result, callback) {
                    result.should.have.property("requestType"); 
                    result.should.have.property("canceledType"); 
                    result.should.have.property("confirmedType"); 
                    result.should.have.property("cutType"); 
                    result.should.have.property("presentType"); 
                    
                    result.requestType.should.have.properties({
                        name: "Requested", 
                        pointValue: 0, 
                        isEnabled: true, 
                        includeShow: false
                    }); 
                    result.canceledType.should.have.properties({
                        name: "Canceled", 
                        pointValue: 0, 
                        isEnabled: true, 
                        includeShow: false
                    }); 
                    result.cutType.should.have.properties({
                        name: "Cut", 
                        pointValue: 20, 
                        isEnabled: true, 
                        includeShow: false
                    }); 
                    result.presentType.should.have.properties({
                        name: "Present", 
                        pointValue: 0, 
                        isEnabled: true, 
                        includeShow: true
                    });
                    result.confirmedType.should.have.properties({
                        name: "Confirmed", 
                        pointValue: 0, 
                        isEnabled: true, 
                        includeShow: false
                    }); 
                    callback();
                }
            ], function() {
                done(); 
            })
        })
    })
})