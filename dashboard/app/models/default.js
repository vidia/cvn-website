module.exports = function(sequalize, DataTypes) {
	var Default = sequalize.define("Default", {
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
		summary: {
			type: DataTypes.TEXT
		}
	},
	{
		classMethods: {

		}
	});

	//Define associations

	return Default;
};