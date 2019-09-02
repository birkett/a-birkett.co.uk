const buildConstants = require('../buildConstants');
const { src, dest } = require('gulp');

module.exports = function imagesTask() {
    return src(`${buildConstants.svgInputDirectory}*${buildConstants.svgExtention}`)
        .pipe(dest(buildConstants.imgOutputDirectory));
};
