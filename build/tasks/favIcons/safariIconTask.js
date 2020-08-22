const fs = require('fs');
const buildConstants = require('../../buildConstants');

module.exports = function safariIconTask(resolve, reject) {
    fs.promises.readFile(buildConstants.faviconInputFile)
        .then((data) => {
            const replaceRegex = new RegExp('fill="#(.*?)"', 'g');
            const outputData = data.toString().replace(replaceRegex, 'fill="#000000"');

            fs.promises.writeFile(buildConstants.safariIconOutputFileName, outputData)
                .then(resolve)
                .catch((writeFileError) => reject(writeFileError));
        })
        .catch((readFileError) => reject(readFileError));
};
