const cleanTask = require('./build/cleanTask');
const stylesTask = require('./build/stylesTask');
const imagesTask = require('./build/imagesTask');
const templateTask = require('./build/templateTask');
const favIconsTask = require('./build/favIcons/favIconsTask');
const safariIconTask = require('./build/favIcons/safariIconTask');
const webManifestTask = require('./build/favIcons/webManifestTask');

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
