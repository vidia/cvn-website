module.exports = function(sequalize, DataTypes) {
	var Season = sequalize.define("Season", {
		uuid: {
			type: DataTypes.UUID,
			defaultValue: DataTypes.UUIDV1,
			primaryKey: true
		},
		startDate: {
			type: DataTypes.DATE
		}, 
		endDate: {
			type: DataTypes.DATE
		}
	});

	//has many shows

	return Season; 
}