module.exports = function(sequalize, DataTypes) {
	var Setting = sequalize.define("Setting", {
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
		value: {
			type: DataTypes.STRING
		}
	},
	{
		classMethods: {
	  		getActiveSeasonId: function(callback){
		    	Setting.findOrCreate({ where: { name: "ActiveSeason" }})
		    	.then(function(setting, created) {
		    		setting = setting[0];
		    		if(setting.value) {
		    			callback(setting.value);
		    		} else {
		    			callback(null);
		    		}
		    	});
	    	},
	    	setActiveSeasonId: function(seasonid, callback) {
	    		Setting.findOrCreate({
                    where: {
                        name: "ActiveSeason"
                    },
                    defaults: {
                        value: seasonid
                    }
                }).then(function(setting) {
                	setting = setting[0];
                	setting.value = seasonid;
                	setting.save()
                	.then(function() {
                		if(callback) {
                			callback();
                		}
                	});
                });
	    	}
	  	},
	  	instanceMethods: {
	    	foo: function() {
	    		return 0;
	    	}
	  	}
	});

	return Setting;
};