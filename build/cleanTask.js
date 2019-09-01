const constants = require('./constants');
const del = require('del');

function cleanTask() {
    return del(constants.outputDirectory);
}

module.exports = cleanTask;
