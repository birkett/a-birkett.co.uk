const fs = require('fs');
const twig = require('twig');
const buildConstants = require('../../buildConstants');

module.exports = function webManifestTask(callback) {
    const data = {
        constants: {
            ...buildConstants.loadJson(buildConstants.templateConstantsJsonPath),
            ...buildConstants,
        },
    };

    twig.renderFile(buildConstants.webManifestInputFileName, data, (err, json) => {
        if (err) {
            throw err;
        }

        fs.writeFile(buildConstants.webManifestOutputFileName, json, callback);
    });
};
