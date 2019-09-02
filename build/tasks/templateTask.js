const buildConstants = require('../buildConstants');
const jsonLoader = require('../jsonLoader');
const fs = require('fs');
const twig = require('twig');

module.exports = function templateTask(callback) {
    const data = {
        constants: jsonLoader.loadTemplateConstants(),
        icons: jsonLoader.loadIcons(),
        tagGroups: jsonLoader.loadTags(),
    };

    twig.renderFile(buildConstants.templateInputFileName, data, (err, html) => {
        if (err) {
            console.log(err);

            return;
        }

        fs.writeFile(buildConstants.templateOutputFileName, html, callback);
    });
};
