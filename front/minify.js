"use strict"

// https://www.npmjs.com/package/uglify-js
const ujs = require('uglify-js');
const fs = require('fs');

let baseDir = './js/';

let files = [

	'lander3.0.js',
	'gtm.js'

];

let code = {};

for(let i = 0; i < files.length; i++){

	let options = {};

	let sourceFileName = files[i];
	let sourceMapFileName = sourceFileName + '.map';
	
	console.log(`start ${sourceFileName}`);

	let minFileName = sourceFileName.replace('.js', '.min.js');
	let minMapFileName = minFileName + '.map';

	let existSourceMapFile = fs.existsSync(baseDir + sourceMapFileName);

	if(existSourceMapFile){

		options.sourceMap = { 
			url: minMapFileName, 
			filename: sourceFileName,
			content: fs.readFileSync(baseDir + sourceMapFileName, 'utf8')
		};

	} else {

		options.sourceMap = { 
			url: minMapFileName,
			filename: sourceFileName
		};

	}

	let src = fs.readFileSync(baseDir + sourceFileName, 'utf8');

	fs.writeFileSync(baseDir + minFileName, ujs.minify(src, options).code, 'utf8');
	fs.writeFileSync(baseDir + minMapFileName, ujs.minify(src, options).map.replace('"sources":["0"]', '"sources":["'+sourceFileName+'"]'), 'utf8');

	console.log(`compiled ${sourceFileName} -> ${minFileName}`);

};