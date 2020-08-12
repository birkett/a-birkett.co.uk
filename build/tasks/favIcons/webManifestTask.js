const fs = require('fs');
const twig = require('twig');
const buildConstants = require('../../buildConstants');

module.exports = function webManifestTask(callback) {
    const data = {
        buildConstants,
        constants: buildConstants.loadJson(buildConstants.templateConstantsJsonPath),
    };

    twig.renderFile(buildConstants.webManifestInputFileName, data, (err, json) => {
        if (err) {
            throw err;
        }

        fs.writeFile(buildConstants.webManifestOutputFileName, json, callback);
    });
};
