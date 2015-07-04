module.exports = function(sequalize, DataTypes) {
	var Setting = sequalize.define("Setting", {
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
		value: {
			type: DataTypes.STRING
		}
	});

	return Setting;
}