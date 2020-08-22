const fs = require('fs');
const buildConstants = require('../buildConstants');

module.exports = function cleanTask(resolve, reject) {
    fs.promises.rmdir(buildConstants.outputDirectory, { recursive: true })
        .then(() => {
            fs.promises.mkdir(buildConstants.outputDirectory)
                .then(resolve)
                .catch((mkdirError) => reject(mkdirError));
        })
        .catch((rmdirError) => reject(rmdirError));
};
