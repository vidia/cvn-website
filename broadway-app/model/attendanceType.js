module.exports = function(sequalize, DataTypes) {
	var AttendanceType = sequalize.define("AttendanceType", {
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
		pointValue: {
			type: DataTypes.INTEGER
		}, 
		isEnabled: {
			type: DataTypes.BOOLEAN, 
			defaultValue: 1, 
			validate: {
				isIn: [[0, 1]]
			}
		}
	});

	return AttendanceType; 
}