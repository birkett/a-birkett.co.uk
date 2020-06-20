const buildConstants = require('../buildConstants');
const { src, dest } = require('gulp');

module.exports = function fontsTask () {
    return src(`${buildConstants.fontInputDirectory}*${buildConstants.fontExtension}`)
        .pipe(dest(buildConstants.fontOutputDirectory));
};
