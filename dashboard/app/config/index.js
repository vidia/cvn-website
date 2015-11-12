if(!process.env.CVNDATABASE)
{
	throw new Error("Must define CVNDATABASE env var with the SQL uri.");
}

module.exports.databaseUri = process.env.CVNDATABASE;