const constants = require('./constants');
const { src, dest } = require('gulp');
const sass = require('gulp-sass');

const SCSS_EXTENSION = '.scss';

function stylesTask() {
    return src(`${constants.scssInputDirectory}*${SCSS_EXTENSION}`)
        .pipe(sass({ outputStyle: 'compressed' }))
        .pipe(dest(constants.cssOutputDirectory));
}

module.exports = stylesTask;
