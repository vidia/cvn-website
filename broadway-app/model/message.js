module.exports = function(sequalize, DataTypes) {
	var Message = sequalize.define("Message", {
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
		datePosted: {
			type: DataTypes.DATE
		}
	});

	//Define associations

	return Message;
}