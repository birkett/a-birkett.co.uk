const buildConstants = require('../buildConstants');
const { src, dest } = require('gulp');

module.exports = function imagesTask() {
    return src(`${buildConstants.svgInputDirectory}*${buildConstants.svgExtension}`)
        .pipe(dest(buildConstants.imgOutputDirectory));
};
