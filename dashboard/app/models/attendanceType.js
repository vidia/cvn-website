var async = require("async");

module.exports = function(sequelize, DataTypes) {
	var AttendanceType = sequelize.define("AttendanceType", {
		uuid: {
			type: DataTypes.UUID,
			defaultValue: DataTypes.UUIDV1,
			primaryKey: true
		},
		name: {
			type: DataTypes.STRING,
			allowNull: false,
			validate: {
				notEmpty: true
			}
		},
		pointValue: {
			type: DataTypes.INTEGER
		},
		isEnabled: { // This will be used to archive old types going into new semesters
						// it will let the old points be calculated based on the old
						// versions, but not let them appear in the new season's options.
						//nTypes should never be deleted, only archived.
			type: DataTypes.BOOLEAN,
			defaultValue: true
		},
		includeShow: { //Points will be calculated by taking the points of the show
						// and the value of the type IF this is true. Otherwise just
						// from the type.
			type: DataTypes.BOOLEAN,
			defaultValue: false
		}
	},
	{
		classMethods: {
			getRequestedType: function(callback) {
				this.findOrCreate({
	    			where: {
		    			name: "Requested"
		    		},
		    		defaults: {
		    			pointValue: 0,
		    			isEnabled: 1,
		    			includeShow: 0
		    		}
	    		}).then(function(typeArr, created) {
	    			callback(typeArr[0], created);
	    		});
			},
			getCanceledType: function(callback) {
				this.findOrCreate({
	    			where: {
		    			name: "Canceled"
		    		},
		    		defaults: {
		    			pointValue: 0,
		    			isEnabled: 1
					}
	    		}).then(function(cancelType, created) {
	    			callback(cancelType[0], created);
	    		});
			},
			getConfirmedType: function(callback) {
				this.findOrCreate({
	    			where: {
		    			name: "Confirmed"
		    		},
		    		defaults: {
		    			pointValue: 0,
		    			isEnabled: 1
					}
	    		}).then(function(confirmedType, created) {
	    			callback(confirmedType[0], created);
	    		});
			},
			getCutType: function(callback) {
				this.findOrCreate({
	    			where: {
		    			name: "Cut"
		    		},
		    		defaults: {
		    			pointValue: 20,
		    			isEnabled: 1
					}
	    		}).then(function(cutType, created) {
	    			callback(cutType[0], created);
	    		});
			},
            getPresentType: function(callback) {
                this.findOrCreate({
                    where: {
                        name: "Present"
                    }, 
                    defaults: {
                        pointValue: 0, 
                        includeShow: 1, 
                        isEnabled: 1
                    }
                }).then(function(presentType, created) {
                    callback(presentType[0], created); 
                })
            },
            getAllDefaultTypes: function(callback) {
                async.parallel(
                    {
                        requestType: function(cb) {
                            AttendanceType.getRequestedType(function(requestType) {
                                cb(null, requestType);
                            });
                        },
                        canceledType: function(cb) {
                            AttendanceType.getCanceledType(function(canceledType) {
                                cb(null, canceledType);
                            });
                        },
                        confirmedType: function(cb) {
                            AttendanceType.getConfirmedType(function(confirmedType) {
                                cb(null, confirmedType);
                            });
                        },
                        cutType: function(cb) {
                            AttendanceType.getCutType(function(cutType) {
                                cb(null, cutType);
                            });
                        }, 
                        presentType: function(cb) {
                            AttendanceType.getPresentType(function(presentType) {
                                cb(null, presentType); 
                            })
                        }
                    }, 
                    function(err, result) {
					   callback(err, result); 
				    }
                );
            },
			getAllDefaultTypesMiddleware: function(req, res, next) {
                this.getAllDefaultTypes(function(err, result) {
                    for (var type in result) { 
                        result[type] = res.locals[type]; 
                    }
                    next(); 
                });
			}
		}
	});

	return AttendanceType;
};