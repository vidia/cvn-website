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
			type: DataType.STRING, 
			validate: {
				isEmail: {
					msg: "Must be a valid email."
				}, 
				notNull: true, 
				notEmpty: true
			}
		}, 
		passwordHash: {
			type: DataType.STRING, 
			validate: {
				notNull: true, 
				notEmpty: true
			}
		}, 


		graduationYear: {
			type: DataType.INTEGER, 
			validate: {
				isYear: function(value) {
					year = parseInt(value)
					if (year > 1900 && year < )
				}
			}
		}

	})
}