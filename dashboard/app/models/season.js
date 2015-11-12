module.exports = function(sequalize, DataTypes) {
	var Season = sequalize.define("Season", {
		uuid: {
			type: DataTypes.UUID,
			defaultValue: DataTypes.UUIDV1,
			primaryKey: true
		},
		name: {
			type: DataTypes.STRING
		},
		startDate: {
			type: DataTypes.DATE
		},
		endDate: {
			type: DataTypes.DATE
		}
	},
	{
		classMethods: {

		}
	});

	//has many shows

	return Season;
}