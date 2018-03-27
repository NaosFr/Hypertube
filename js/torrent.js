let torrentStream = require('torrent-stream');
let mysql = require('mysql');

if (process.argv[2] == undefined)
{
	console.log("error");
}
else
{
	let magnet = 'magnet:?xt=urn:btih:' + process.argv[2];
	let engine = torrentStream(magnet, {path: '../films'});
	engine.on('ready', function() {
		engine.files.forEach(function(file) {
			if (file.name.substr(file.name.length - 3) == 'mkv' || file.name.substr(file.name.length - 3) == 'mp4')
			{
				var con = mysql.createConnection({
					host: "127.0.0.1",
					user: "root",
					password: "root",
					database: "hypertube"
				});
				con.connect(function (err) {
					if (err) throw err;
					let sql = "INSERT INTO hash (hash, path) VALUES ?";
					let values = [
						[process.argv[2], file.path]
					];
					con.query(sql, [values], function (err, result) {
						if (err) throw err;
					});
				});
				let stream = file.createReadStream();
			}
		});
	});
	engine.on('download', function(data) {
		console.log('piece downloaded :', data);
	});
	engine.on('idle', function() {
		console.log('torrent end');
	});
}
