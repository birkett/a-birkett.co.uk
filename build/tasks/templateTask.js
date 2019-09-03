const buildConstants = require('../buildConstants');
const jsonLoader = require('../jsonLoader');
const fs = require('fs');
const twig = require('twig');

module.exports = function templateTask (callback) {
    const data = {
        buildConstants: buildConstants,
        constants: jsonLoader.loadTemplateConstants(),
        icons: jsonLoader.loadIcons(),
        tagGroups: jsonLoader.loadTags(),
    };

    twig.renderFile(buildConstants.templateInputFileName, data, (err, html) => {
        if (err) { throw err; }

        fs.writeFile(buildConstants.templateOutputFileName, html, callback);
    });
};
