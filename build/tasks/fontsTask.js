const { src, dest } = require('gulp');
const buildConstants = require('../buildConstants');

module.exports = function fontsTask() {
    return src(`${buildConstants.fontInputDirectory}*${buildConstants.fontExtension}`)
        .pipe(dest(buildConstants.fontOutputDirectory));
};
