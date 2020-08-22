const fs = require('fs');
const sass = require('node-sass');
const buildConstants = require('../buildConstants');

module.exports = function stylesTask(resolve, reject) {
    fs.promises.readFile(`${buildConstants.scssInputDirectory}main.scss`)
        .then((scss) => {
            const sassOptions = {
                outputStyle: 'compressed',
                includePaths: [buildConstants.scssInputDirectory],
                data: `$gitRevision: ${buildConstants.gitRevision()}; ${scss}`,
            };

            const renderCallback = (renderError, result) => {
                if (renderError) {
                    reject(renderError);

                    return;
                }

                fs.promises.mkdir(buildConstants.cssOutputDirectory)
                    .catch(() => {})
                    .then(() => {
                        const dest = `${buildConstants.cssOutputDirectory}/main.css`;

                        fs.promises.writeFile(dest, result.css.toString())
                            .then(resolve)
                            .catch((writeFileError) => reject(writeFileError));
                    });
            };

            sass.render(sassOptions, renderCallback);
        })
        .catch((readFileError) => reject(readFileError));
};
