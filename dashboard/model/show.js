module.exports = function(sequalize, DataTypes) {
	var Show = sequalize.define("Show", {
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
		showtime: {
			type: DataTypes.DATE
		}, 
		calltime: {
			type: DataTypes.DATE
		}, 
		posttime: {
			type: DataTypes.DATE
		}, 
		summary: {
			type: DataTypes.TEXT
		}
	});

	//Define associations

	return Show;
}