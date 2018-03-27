let torrentStream = require('torrent-stream');
let mysql = require('mysql');

if (process.argv[2] == undefined)
{
	console.log("error");
}
else
{
	let firstPiece;
	let lastPiece;
	let got = 0;

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

				var fileStart = file.offset;
				var fileEnd = file.offset + file.length;

				var pieceLength = engine.torrent.pieceLength;

				firstPiece = Math.floor(fileStart / pieceLength);
				lastPiece = Math.floor((fileEnd - 1) / pieceLength);
			}
		});
	});
	engine.on('download', function(data) {
		if (data >= firstPiece && data <= lastPiece)
		{
			got++;
			let percent = (got / (lastPiece + 1)) * 100;
			percent = Math.round(percent * 100) / 100;
			console.log(percent + "%");
		}
	});
	engine.on('idle', function() {
		console.log('torrent end');
	});
}
