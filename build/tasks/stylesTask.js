const buildConstants = require('../buildConstants');
const { src, dest } = require('gulp');
const sass = require('gulp-sass');

module.exports = function stylesTask() {
    return src(`${buildConstants.scssInputDirectory}*${buildConstants.scssExtention}`)
        .pipe(sass({ outputStyle: 'compressed' }))
        .pipe(dest(buildConstants.cssOutputDirectory));
};
