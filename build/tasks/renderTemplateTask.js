const fs = require('fs');
const twig = require('twig');
const util = require('util');
const buildConstants = require('../buildConstants');

const basicRenderTask = (resolve, reject, source, destination, additionalData) => {
    const data = {
        constants: {
            ...buildConstants.loadJson(buildConstants.templateConstantsJsonPath),
            ...buildConstants,
        },
        ...additionalData,
    };

    util.promisify(twig.renderFile)(source, data)
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
                links: buildConstants.loadJson(buildConstants.headerLinksJsonPath),
                tagGroups: buildConstants.loadJson(buildConstants.tagsJsonPath),
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
};
