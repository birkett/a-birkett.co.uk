const fs = require('fs');
const twig = require('twig');
const buildConstants = require('../buildConstants');

module.exports = function templateTask(callback) {
    const data = {
        constants: {
            ...buildConstants.loadJson(buildConstants.templateConstantsJsonPath),
            ...buildConstants,
        },
        links: buildConstants.loadJson(buildConstants.headerLinksJsonPath),
        tagGroups: buildConstants.loadJson(buildConstants.tagsJsonPath),
    };

    twig.renderFile(buildConstants.templateInputFileName, data, (err, html) => {
        if (err) {
            throw err;
        }

        fs.writeFile(buildConstants.templateOutputFileName, html, callback);
    });
};
