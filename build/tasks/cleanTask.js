const del = require('del');
const buildConstants = require('../buildConstants');

module.exports = function cleanTask() {
    return del(buildConstants.outputDirectory);
};
