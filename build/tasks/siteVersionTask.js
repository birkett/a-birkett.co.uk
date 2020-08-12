const childProcess = require('child_process');
const fs = require('fs');
const buildConstants = require('../buildConstants');

module.exports = function siteVersionTask(callback) {
    childProcess.exec('git rev-parse --short HEAD', (err, stdout) => {
        if (err) {
            throw err;
        }

        if (!fs.existsSync(buildConstants.outputDirectory)) {
            fs.mkdirSync(buildConstants.outputDirectory);
        }

        fs.writeFile(
            `${buildConstants.outputDirectory}site.version`,
            stdout.split('\n').join(''),
            callback,
        );
    });
};
