var bcrypt = require('bcryptjs');

module.exports = function(sequalize, DataTypes) {
	var User = sequalize.define("User", {
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
	},
	{
	  classMethods: {
	    method1: function(){ return 'smth' }
	  },
	  instanceMethods: {
	    checkPassword: function() { 
	    	return 'foo'; 
	    }
	  }
	}) //end define

	//user associations


	return User; 
} //end exports