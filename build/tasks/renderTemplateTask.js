const fs = require('fs');
const twig = require('twig');
const buildConstants = require('../buildConstants');

function basicRenderTask(resolve, reject, source, destination, additionalData) {
    const data = {
        constants: {
            ...buildConstants.loadJson(buildConstants.templateConstantsJsonPath),
            ...buildConstants,
        },
        ...additionalData,
    };

    twig.renderFile(source, data, (renderFileError, renderedTemplate) => {
        if (renderFileError) {
            reject(renderFileError);

            return;
        }

        fs.promises.writeFile(destination, renderedTemplate)
            .then(resolve)
            .catch((writeFileError) => reject(writeFileError));
    });
}

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
