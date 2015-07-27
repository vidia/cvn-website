module.exports = function()
{
	if(process.env.CVNDATABASE)
	{
		return process.env.CVNDATABASE; 
	}
	else 
	{
		throw new Error("Must define CVNDATABASE env var with the SQL uri.")
	}
}