const OS = require('opensubtitles-api');
const OpenSubtitles = new OS({useragent:'TemporaryUserAgent'});
var http = require('http');
var fs = require('fs');

var lang = ['fre', 'eng'];

exports.dlSubtitles = function(hash, imdb, path) {
	OpenSubtitles.search({
		sublanguageid: lang.join(),
		hash: hash,
		extensions: ['srt'],
		imdbid: imdb,
	}).then(subtitles => {
		if (subtitles['en'] && !fs.existsSync("../films/" + path + "/en.srt"))
		{
			var fileen = fs.createWriteStream("../films/" + path + "/en.srt");
			var requesten = http.get(subtitles['en']['url'], function(response) {
				response.pipe(fileen);
				fileen.on('finish', function() {
					fileen.close();
				});
			});
		}
		if (subtitles['fr'] && !fs.existsSync("../films/" + path + "/fr.srt"))
		{
			filefr = fs.createWriteStream("../films/" + path + "/fr.srt");
			requestfr = http.get(subtitles['fr']['url'], function(response) {
				response.pipe(filefr);
				filefr.on('finish', function() {
					filefr.close();
				});
			});
		}
	});
}
