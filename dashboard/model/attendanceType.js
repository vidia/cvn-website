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
	});

	return AttendanceType; 
}