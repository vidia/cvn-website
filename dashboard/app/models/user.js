var bcrypt = require('bcryptjs');

module.exports = function(sequelize, DataTypes) {
	var Attendance = sequelize.import("attendance", require("./attendance")); 
	var AttendanceType = sequelize.import("attendanceType", require("./attendanceType"));
	
	var User = sequelize.define("User", {
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
		preferedname: {
			type: DataTypes.STRING,
			defaultValue: null,
			allowNull: true
		},
		email: {
			type: DataTypes.STRING,
			allowNull: false,
			validate: {
				isEmail: {
					msg: "Must be a valid email."
				},
				notEmpty: true
			}
		},
		password: {
			type: DataTypes.STRING,
			allowNull: false,
			validate: {
				notEmpty: true
			},
			set: function(value) {
				console.log("Hashing password");
				var salt = bcrypt.genSaltSync(10);
	            var hash = bcrypt.hashSync(value, salt);

	            this.setDataValue('password', hash);
	            this.setDataValue("passwordsalt", salt);
			}
		},
		passwordsalt: {
			type: DataTypes.STRING,
			allowNull: false,
			validate: {
				notEmpty: true
			}
		},
		accountType: {
			type: DataTypes.ENUM(
				"UC",
				"Usher",
				"Admin"
			),
			defaultValue: "Usher"
		},


		graduationYear: {
			type: DataTypes.INTEGER,
			validate: {
				isYear: function(value) {
					var year = parseInt(value);
					if (year > 1800 && year < 2999)
					{
						return;
					} else {
						throw new Error("Please enter a reasonable year.");
					}
				}
			}
		},
		college: {
			type: DataTypes.STRING
		},
		birthday: {
			type: DataTypes.DATE
		},
		residence: {
			type: DataTypes.ENUM(
				"Non-Residence Hall",
				"Cary Quadrangle",
				"Earhart Hall",
				"First Street Towers",
				"Third Street Suites",
				"Harrison Hall",
				"Hawkins Hall",
				"Hillenbrand Hall",
				"Hilltop Apartments",
				"McCutcheon Hall",
				"Meredith Hall",
				"Owen Hall",
				"Purdue Village",
				"Shreve Hall",
				"Tarkington Hall",
				"Wiley Hall",
				"Windsor Hall"
			)
		},

		favorite_artist: {
			type: DataTypes.STRING
		},
		favorite_song: {
			type: DataTypes.STRING
		},
		favorite_book: {
			type: DataTypes.STRING
		},
		favorite_show: {
			type: DataTypes.STRING
		}
	},
	{
		defaultScope: {
            
        },
        scopes: {
            /*pointsScope: {
                
		      include: [
				{
					model: Attendance,
					as: "Attendances",
					include: [
						{
							attributes: [ 
								[
									sequelize.fn('SUM', sequelize.col('Attendances.AttendanceType.pointValue')),
									'points'
								]
							], 
							model:AttendanceType
						}
					]
				}
		      ]
           }*/
        }, 
		classMethods: {
	  	},
	  	instanceMethods: {
	    	checkPassword: function(password) {
	    		return bcrypt.compareSync(password, this.password);
	    	},
            getPoints: function(callback) {
                sequelize.query(
                    "select users.name, attendanceTypes.includeShow, sum(attendanceTypes.pointValue), sum(E.pointValue), "+
                    "sum(case "+
                    "when attendanceTypes.includeShow = 1 then attendanceTypes.pointValue + E.pointValue "+
                    "else attendanceTypes.pointValue "+
                    "end) "+
                    "as 'userPoints' from users "+
                    "join attendances on users.uuid = attendances.UserUuid "+
                    "join events as E on attendances.EventUuid = E.uuid "+
                    "join attendanceTypes on attendanceTypes.uuid = attendances.AttendanceTypeUuid "+
                    "where users.uuid = '" + this.uuid + "' "+ 
                    "group by users.uuid",
                        { 
                            type: sequelize.QueryTypes.SELECT
                        }
                ).then(function(result) {
                    callback(null, result[0].userPoints); 
                });
            }
            
	  	}
	}); //end define

	//user associations


	return User;
}; //end exports