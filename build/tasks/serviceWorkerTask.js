const fs = require('fs');
const path = require('path');
const { basicRenderTask } = require('./renderTemplateTask');
const buildConstants = require('../buildConstants');

const getFiles = (baseDirectory) => {
    const foundFiles = [];

    const recurseDirectory = (directory) => {
        const files = fs.readdirSync(directory);

        files.forEach((file) => {
            const absolute = path.join(directory, file);
            const fileEnt = fs.statSync(absolute);

            return fileEnt.isDirectory()
                ? recurseDirectory(absolute)
                : foundFiles.push(absolute);
        });
    };

    recurseDirectory(baseDirectory);

    const trimmedFiles = [];

    foundFiles.forEach((file) => {
        // Skip over most favicons, the browser should have already cached what it needs.
        if (file.includes('.png')) {
            return;
        }

        const trimmedRootPath = file.substring(file.indexOf('/') + 1);
        const fileName = `./${trimmedRootPath}?v=${buildConstants.gitRevision()}`;

        trimmedFiles.push(fileName);
    });

    return trimmedFiles;
};

const serviceWorkerTask = (resolve, reject) => {
    const files = getFiles(buildConstants.outputDirectory);

    basicRenderTask(
        resolve,
        reject,
        buildConstants.serviceWorkerInputFileName,
        buildConstants.serviceWorkerOutputFileName,
        { files },
    );
};

module.exports = serviceWorkerTask;
