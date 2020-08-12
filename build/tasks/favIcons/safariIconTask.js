const fs = require('fs');
const buildConstants = require('../../buildConstants');

module.exports = function safariIconTask(callback) {
    fs.readFile(buildConstants.faviconInputFile, (err, data) => {
        if (err) {
            throw err;
        }

        const replaceRegex = new RegExp('fill="#(.*?)"', 'g');
        const outputData = data.toString().replace(replaceRegex, 'fill="#000000"');

        fs.writeFile(buildConstants.safariIconOutputFileName, outputData, callback);
    });
};
