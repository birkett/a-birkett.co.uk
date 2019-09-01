const constants = require('./constants');
const { src, dest } = require('gulp');

function imagesTask() {
    return src(`${constants.svgInputDirectory}*${constants.svgExtention}`)
        .pipe(dest(constants.imgOutputDirectory));
}

module.exports = imagesTask;
