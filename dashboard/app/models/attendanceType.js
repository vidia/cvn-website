var async = require("async");

module.exports = function(sequalize, DataTypes) {
	var AttendanceType = sequalize.define("AttendanceType", {
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
		    			points: 0,
		    			isEnabled: 1,
		    			includeShow: 1
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
		    			points: 0,
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
		    			points: 0,
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
		    			points: 20,
		    			isEnabled: 1
					}
	    		}).then(function(cutType, created) {
	    			callback(cutType[0], created);
	    		});
			},
			getAllDefaultTypesMiddleware: function(req, res, next) {
				async.parallel([
					function(cb) {
						AttendanceType.getRequestedType(function(requestType) {
			    			res.locals.requestType = requestType;
			    			cb(null);
			    		});
					},
					function(cb) {
						AttendanceType.getCanceledType(function(canceledType) {
			    			res.locals.cancelType = canceledType;
			    			cb(null);
			    		});
					},
					function(cb) {
						AttendanceType.getConfirmedType(function(confirmedType) {
			    			res.locals.confirmedType = confirmedType;
			    			cb(null);
			    		});
					},
					function(cb) {
						AttendanceType.getCutType(function(cutType) {
			    			res.locals.cutType = cutType;
			    			cb(null);
			    		});
					}
				], function() {
					next();
				});
			}
		}
	});

	return AttendanceType;
};