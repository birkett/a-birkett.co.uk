const { src, dest } = require('gulp');
const sass = require('gulp-sass');
const sassVariables = require('gulp-sass-variables');
const buildConstants = require('../buildConstants');

module.exports = function stylesTask() {
    return src(`${buildConstants.scssInputDirectory}*.scss`)
        .pipe(sassVariables({
            $gitRevision: buildConstants.gitRevision(),
        }))
        .pipe(sass({ outputStyle: 'compressed' }))
        .pipe(dest(buildConstants.cssOutputDirectory));
};
