const buildConstants = require('../buildConstants');
const del = require('del');

module.exports = function cleanTask() {
    return del(buildConstants.outputDirectory);
};
