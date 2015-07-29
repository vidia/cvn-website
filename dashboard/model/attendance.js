module.exports = function(sequalize, DataTypes) {
	var Attendance = sequalize.define("Attendance", {
		uuid: {
			type: DataTypes.UUID,
			defaultValue: DataTypes.UUIDV1,
			primaryKey: true
		}
	});

	//belongs to? 

	
	//has one attendancetype. 
	//has one show?

	return Attendance;
}