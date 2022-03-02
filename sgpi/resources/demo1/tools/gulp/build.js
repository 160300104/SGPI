var yargs = require('yargs');
var fs = require('fs');
var colors = require('colors');
global.atob = require('atob');

var release = true;

// merge with default parameters
var args = Object.assign({
	prod: false,
	default: false,
	angular: false,
	theme: '',
}, yargs.argv);

var theme = atob('bWV0cm9uaWM=');
var pkg = 'default';
var confPath = '';

if (release) {
	['default', 'angular'].forEach(function(p) {
		if (args[p]) {
			pkg = p;
		}
	});
	// @todo fix gulp path release
	confPath = './../conf/' + pkg + '.json';

} else {
	[theme, 'keen'].forEach(function(t) {
		if (args[t]) {
			theme = t;
		}
		['default', 'angular'].forEach(function(p) {
			if (args[p]) {
				pkg = p;
			}
		});
	});
	confPath = './../../themes/themes/' + theme + '/tools/conf/' + pkg + '.json';
}

var d = new Date();
var t = d.getHours() + ':' + d.getMinutes() + ':' + d.getSeconds();
console.log('[' + t.grey + ']' + ' ' + 'Using config ' + confPath.green);
module.exports = require(confPath);
module.exports.config.theme = theme;
