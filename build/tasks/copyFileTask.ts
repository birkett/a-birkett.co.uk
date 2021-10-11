const fs = require('fs');
const promiseInOrder = require('../../lib/promise/inOrder');
const buildConstants = require('../buildConstants');

const basicCopyTask = (resolve, reject, source, destination) => {
    fs.promises.readdir(source)
        .then((files) => {
            fs.promises.mkdir(destination)
                .catch(() => {})
                .then(() => {
                    const promiseFunction = (previous, next) => {
                        const copySource = `${source}${next}`;
                        const copyDest = `${destination}${next}`;

                        return fs.promises.copyFile(copySource, copyDest)
                            .catch((copyFileError) => reject(copyFileError));
                    };

                    promiseInOrder(files, promiseFunction)
                        .then(resolve);
                });
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
