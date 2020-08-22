const fs = require('fs');
const buildConstants = require('../buildConstants');

const basicCopyTask = (resolve, reject, source, destination) => {
    fs.promises.readdir(source)
        .then((files) => {
            fs.promises.mkdir(destination).catch(() => {});

            return files;
        })
        .then((files) => {
            files.forEach((file) => {
                fs.promises.copyFile(`${source}/${file}`, `${destination}/${file}`)
                    .catch((copyFileError) => reject(copyFileError));
            });

            resolve();
        })
        .catch((readDirError) => reject(readDirError));
};

module.exports = {
    fonts: (resolve, reject) => {
        basicCopyTask(
            resolve,
            reject,
            buildConstants.fontInputDirectory,
            buildConstants.fontOutputDirectory,
        );
    },

    images: (resolve, reject) => {
        basicCopyTask(
            resolve,
            reject,
            buildConstants.svgInputDirectory,
            buildConstants.imgOutputDirectory,
        );
    },
};
