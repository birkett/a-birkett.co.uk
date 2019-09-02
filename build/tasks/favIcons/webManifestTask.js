const buildConstants = require('../../buildConstants');
const jsonLoader = require('../../jsonLoader');
const fs = require('fs');
const twig = require('twig');

module.exports = function webManifestTask(callback) {
    const data = {
        constants: jsonLoader.loadTemplateConstants(),
    };

    twig.renderFile(buildConstants.webManifestInputFileName, data, (err, json) => {
        if (err) {
            console.log(err);

            return;
        }

        fs.writeFile(buildConstants.webManifestOutputFileName, json, callback);
    });
};
