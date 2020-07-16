<?

const DB_HOST = "localhost";
const DB_NAME = "status";
const DB_USER = "mysql";
const DB_PASS = "mysql";

function get_connection(){
	return new PDO('mysql:host='. DB_HOST .';dbname='. DB_NAME , DB_USER, DB_PASS);
}
