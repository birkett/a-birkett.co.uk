const { src, dest } = require('gulp');
const buildConstants = require('../buildConstants');

module.exports = function fontsTask() {
    return src(`${buildConstants.fontInputDirectory}*.woff2`)
        .pipe(dest(buildConstants.fontOutputDirectory));
};
