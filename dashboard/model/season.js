module.exports = function(sequalize, DataTypes) {
	var Season = sequalize.define("Season", {
		uuid: {
			type: DataTypes.UUID,
			defaultValue: DataTypes.UUIDV1,
			primaryKey: true
		},
		year: {
			type: DataTypes.INTEGER, 
			validate: {
				isYear: function(value) {
					year = parseInt(value)
					if (year > 1800 && year < 2999)
					{
						return;
					} else {
						throw new Error("Please enter a reasonable year.")
					}
				}
			}
		}
	});

	//has many shows

	return Season; 
}