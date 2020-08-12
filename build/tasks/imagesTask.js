const { src, dest } = require('gulp');
const buildConstants = require('../buildConstants');

module.exports = function imagesTask() {
    return src(`${buildConstants.svgInputDirectory}*${buildConstants.svgExtension}`)
        .pipe(dest(buildConstants.imgOutputDirectory));
};
