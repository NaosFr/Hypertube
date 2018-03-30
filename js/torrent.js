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
	let old = 0;
	let hash = process.argv[2];

	var con = mysql.createConnection({
		host: "127.0.0.1",
		user: "root",
		password: "root",
		database: "hypertube"
	});

	con.connect(function (err) {
		if (err) throw err;
	});

	let magnet = 'magnet:?xt=urn:btih:' + process.argv[2];
	let engine = torrentStream(magnet, {path: '../films'});
	engine.on('ready', function() {
		engine.files.forEach(function(file) {
			if (file.name.substr(file.name.length - 3) == 'mkv' || file.name.substr(file.name.length - 3) == 'mp4')
			{
				let sql = "INSERT INTO hash (hash, path, downloaded) VALUES ?";
				let values = [
					[hash, file.path, 0]
				];
				con.query(sql, [values], function (err, result) {
					if (err) throw err;
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
			percent = Math.round(percent);
			console.log(percent + "%");
			if (percent >= old + 1)
			{
				let sql = "UPDATE hash SET downloaded = ? WHERE hash = ?";
				con.query(sql, [percent, hash], function (err, result) {
					if (err) throw err;
				});
				old = percent;
			}
		}
	});
	engine.on('idle', function() {
		console.log('torrent end');
	});
}
