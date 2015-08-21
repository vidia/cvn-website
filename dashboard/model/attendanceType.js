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
		isEnabled: {
			type: DataTypes.BOOLEAN
		}
	});

	return AttendanceType; 
}