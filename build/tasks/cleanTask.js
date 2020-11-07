const fs = require('fs');
const buildConstants = require('../buildConstants');

const cleanTask = (resolve, reject) => {
    const recreatedOutputDirectory = (res, rej) => {
        fs.promises.mkdir(buildConstants.outputDirectory)
            .then(res)
            .catch((mkdirError) => rej(mkdirError));
    };

    fs.promises.stat(buildConstants.outputDirectory)
        .then(() => {
            fs.promises.rmdir(buildConstants.outputDirectory, { recursive: true })
                .then(() => recreatedOutputDirectory(resolve, reject))
                .catch((rmdirError) => reject(rmdirError));
        })
        .catch(() => {
            recreatedOutputDirectory(resolve, reject);
        });
};

module.exports = cleanTask;
