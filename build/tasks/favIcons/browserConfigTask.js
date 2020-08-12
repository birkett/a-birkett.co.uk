const fs = require('fs');
const twig = require('twig');
const buildConstants = require('../../buildConstants');

module.exports = function browserConfigTask(callback) {
    const data = {
        buildConstants,
        constants: buildConstants.loadJson(buildConstants.templateConstantsJsonPath),
    };

    twig.renderFile(buildConstants.browserConfigInputFileName, data, (err, json) => {
        if (err) {
            throw err;
        }

        fs.writeFile(buildConstants.browserConfigOutputFileName, json, callback);
    });
};
