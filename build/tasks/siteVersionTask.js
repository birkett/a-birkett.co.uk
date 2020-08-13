const fs = require('fs');
const buildConstants = require('../buildConstants');

module.exports = function siteVersionTask(callback) {
    fs.access(buildConstants.outputDirectory, fs.constants.F_OK, (accessErr) => {
        const writeFile = () => {
            fs.writeFile(
                buildConstants.siteVersionFile,
                buildConstants.gitRevision(),
                callback,
            );
        };

        if (accessErr) {
            fs.mkdir(buildConstants.outputDirectory, (mkdirErr) => {
                if (mkdirErr) {
                    throw mkdirErr;
                }

                writeFile();
            });

            return;
        }

        writeFile();
    });
};
