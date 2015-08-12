module.exports = function(sequalize, DataTypes) {
	var Event = sequalize.define("Event", {
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
		location: {
			type: DataTypes.STRING
		},
		showtime: {
			type: DataTypes.DATE
		}, 
		calltime: {
			type: DataTypes.DATE
		}, 
		posttime: {
			type: DataTypes.DATE
		}, 
		description: {
			type: DataTypes.TEXT
		}
	});

	//Define associations

	return Event;
}