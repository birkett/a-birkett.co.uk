const constants = require('../constants');
const fs = require('fs');

const SAFARI_ICON_FILE_NAME = 'safari-pinned-tab' + constants.svgExtention;

function safariIconTask(callback) {
    const inputFile = fs.readFileSync(constants.faviconInputFile);
    const replaceRegex = new RegExp('fill="#(.*?)"', 'g');

    fs.writeFile(
        `${constants.outputDirectory}${SAFARI_ICON_FILE_NAME}`,
        inputFile.toString().replace(replaceRegex, 'fill="#000000"'),
        callback
    );
}

module.exports = safariIconTask;
