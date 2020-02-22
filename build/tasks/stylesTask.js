const buildConstants = require('../buildConstants');
const { src, dest } = require('gulp');
const sass = require('gulp-sass');
const sassVariables = require('gulp-sass-variables');

module.exports = function stylesTask () {
    return src(`${buildConstants.scssInputDirectory}*${buildConstants.scssExtension}`)
        .pipe(sassVariables({
            $siteVersion: buildConstants.siteVersion()
        }))
        .pipe(sass({ outputStyle: 'compressed' }))
        .pipe(dest(buildConstants.cssOutputDirectory));
};
