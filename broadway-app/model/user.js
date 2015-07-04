module.exports = function(sequalize, DataTypes) {
	var User = sequalize.define("User", {
		uuid: {
			type: DataTypes.UUID,
			defaultValue: DataTypes.UUIDV1,
			primaryKey: true
		},
		name: {
			type: DataTypes.STRING,
			validate: {
				notEmpty: true, 
				notNull: true
			}
		},
		preferedname: {
			type: DataTypes.STRING, 
			defaultValue: null, 
			allowNull: true
		},
		email: {
			type: DataTypes.STRING, 
			validate: {
				isEmail: {
					msg: "Must be a valid email."
				}, 
				notNull: true, 
				notEmpty: true
			}
		}, 
		passwordHash: {
			type: DataTypes.STRING, 
			validate: {
				notNull: true, 
				notEmpty: true
			}
		}, 
		accountType: {
			type: DataTypes.ENUM(
				"UC", 
				"Usher", 
				"Admin"
			)
		}, 


		graduationYear: {
			type: DataTypes.INTEGER, 
			validate: {
				isYear: function(value) {
					year = parseInt(value)
					if (year > 1800 && year < 2999)
					{
						return;
					} else {
						throw new Error("Please enter a reasonable year.")
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
	}) //end define

	//user associations


	return User; 
} //end exports