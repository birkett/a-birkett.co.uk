const buildConstants = require('../../buildConstants');
const fs = require('fs');

module.exports = function safariIconTask(callback) {
    const inputFile = fs.readFileSync(buildConstants.faviconInputFile);
    const replaceRegex = new RegExp('fill="#(.*?)"', 'g');

    fs.writeFile(
        buildConstants.safariIconFileName,
        inputFile.toString().replace(replaceRegex, 'fill="#000000"'),
        callback
    );
};
