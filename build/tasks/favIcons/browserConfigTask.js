const buildConstants = require('../../buildConstants');
const jsonLoader = require('../../jsonLoader');
const fs = require('fs');
const twig = require('twig');

module.exports = function browserConfigTask (callback) {
    const data = {
        buildConstants: buildConstants,
        constants: jsonLoader.loadTemplateConstants(),
    };

    twig.renderFile(buildConstants.browserConfigInputFileName, data, (err, json) => {
        if (err) { throw err; }

        fs.writeFile(buildConstants.browserConfigOutputFileName, json, callback);
    });
};
