const fs = require('fs');
const nunjucks = require('nunjucks');
const util = require('util');
const buildConstants = require('../buildConstants');

const loadJson = (path) => JSON.parse(fs.readFileSync(path).toString());

const basicRenderTask = (resolve, reject, source, destination, additionalData) => {
    const data = {
        constants: {
            ...loadJson(buildConstants.templateConstantsJsonPath),
            ...buildConstants,
        },
        ...additionalData,
    };

    util.promisify(nunjucks.render)(source, data)
        .then((renderedTemplate) => {
            fs.promises.writeFile(destination, renderedTemplate)
                .then(resolve)
                .catch((writeFileError) => reject(writeFileError));
        })
        .catch((renderFileError) => reject(renderFileError));
};

module.exports = {
    browserConfig: (resolve, reject) => {
        basicRenderTask(
            resolve,
            reject,
            buildConstants.browserConfigInputFileName,
            buildConstants.browserConfigOutputFileName,
        );
    },

    indexTemplate: (resolve, reject) => {
        basicRenderTask(
            resolve,
            reject,
            buildConstants.templateInputFileName,
            buildConstants.templateOutputFileName,
            {
                links: loadJson(buildConstants.headerLinksJsonPath),
                tagGroups: loadJson(buildConstants.tagsJsonPath),
            },
        );
    },

    webManifest: (resolve, reject) => {
        basicRenderTask(
            resolve,
            reject,
            buildConstants.webManifestInputFileName,
            buildConstants.webManifestOutputFileName,
        );
    },

    basicRenderTask,
};
