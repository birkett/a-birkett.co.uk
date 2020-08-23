const fs = require('fs');
const buildConstants = require('../buildConstants');

const basicCopyTask = (resolve, reject, source, destination) => {
    fs.promises.readdir(source)
        .then((files) => {
            fs.promises.mkdir(destination)
                .catch(() => {})
                .then(() => {
                    const reducer = async (previous, next) => {
                        await previous;

                        return fs.promises.copyFile(`${source}${next}`, `${destination}${next}`)
                            .catch((copyFileError) => reject(copyFileError));
                    };

                    files.reduce(reducer, Promise.resolve())
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
