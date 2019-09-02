const cleanTask = require('./build/tasks/cleanTask');
const stylesTask = require('./build/tasks/stylesTask');
const imagesTask = require('./build/tasks/imagesTask');
const templateTask = require('./build/tasks/templateTask');
const favIconsTask = require('./build/tasks/favIcons/favIconsTask');
const safariIconTask = require('./build/tasks/favIcons/safariIconTask');
const webManifestTask = require('./build/tasks/favIcons/webManifestTask');

const { series } = require('gulp');

const iconsGroupTask = series(favIconsTask, safariIconTask, webManifestTask);

exports.clean = cleanTask;
exports.styles = stylesTask;
exports.images = imagesTask;
exports.template = templateTask;
exports.favIcons = favIconsTask;
exports.safariIcon = safariIconTask;
exports.webManifest = webManifestTask;

exports.icons = iconsGroupTask;

exports.default = series(cleanTask, stylesTask, imagesTask, templateTask, iconsGroupTask);
