const childProcess = require('child_process');
const fs = require('fs');
const buildConstants = require('../buildConstants');

module.exports = function siteVersionTask(callback) {
    childProcess.exec('git rev-parse --short HEAD', (execErr, stdout) => {
        if (execErr) {
            throw execErr;
        }

        fs.access(buildConstants.outputDirectory, fs.constants.F_OK, (accessErr) => {
            const writeFile = () => {
                fs.writeFile(
                    `${buildConstants.outputDirectory}site.version`,
                    stdout.split('\n').join(''),
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
    });
};
