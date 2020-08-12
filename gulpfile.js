const { series } = require('gulp');

const cleanTask = require('./build/tasks/cleanTask');
const siteVersionTask = require('./build/tasks/siteVersionTask');
const stylesTask = require('./build/tasks/stylesTask');
const imagesTask = require('./build/tasks/imagesTask');
const fontsTask = require('./build/tasks/fontsTask');
const templateTask = require('./build/tasks/templateTask');
const favIconsTask = require('./build/tasks/favIcons/favIconsTask');
const safariIconTask = require('./build/tasks/favIcons/safariIconTask');
const webManifestTask = require('./build/tasks/favIcons/webManifestTask');
const browserConfigTask = require('./build/tasks/favIcons/browserConfigTask');

const iconsGroupTask = series(favIconsTask, safariIconTask, webManifestTask, browserConfigTask);

exports.clean = cleanTask;
exports.siteVersion = siteVersionTask;
exports.styles = stylesTask;
exports.images = imagesTask;
exports.fonts = fontsTask;
exports.template = templateTask;
exports.favIcons = favIconsTask;
exports.safariIcon = safariIconTask;
exports.webManifest = webManifestTask;
exports.browserConfig = browserConfigTask;

exports.icons = iconsGroupTask;

exports.default = series(
    cleanTask,
    siteVersionTask,
    stylesTask,
    imagesTask,
    fontsTask,
    templateTask,
    iconsGroupTask,
);
