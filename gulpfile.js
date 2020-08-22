const { series } = require('gulp');

const cleanTask = require('./build/tasks/cleanTask');
const stylesTask = require('./build/tasks/stylesTask');
const imagesTask = require('./build/tasks/imagesTask');
const fontsTask = require('./build/tasks/fontsTask');
const templateTask = require('./build/tasks/templateTask');
const favIconsTask = require('./build/tasks/favIcons/favIconsTask');
const safariIconTask = require('./build/tasks/favIcons/safariIconTask');
const webManifestTask = require('./build/tasks/favIcons/webManifestTask');
const browserConfigTask = require('./build/tasks/favIcons/browserConfigTask');

const iconsGroupTask = series(
    safariIconTask,
    webManifestTask,
    browserConfigTask,
    favIconsTask,
);

const fastTask = series(
    stylesTask,
    imagesTask,
    templateTask,
);

const defaultTask = series(
    cleanTask,
    stylesTask,
    imagesTask,
    fontsTask,
    templateTask,
    iconsGroupTask,
);

exports.clean = cleanTask;
exports.styles = stylesTask;
exports.images = imagesTask;
exports.fonts = fontsTask;
exports.template = templateTask;
exports.favIcons = favIconsTask;
exports.safariIcon = safariIconTask;
exports.webManifest = webManifestTask;
exports.browserConfig = browserConfigTask;
exports.icons = iconsGroupTask;
exports.fast = fastTask;
exports.default = defaultTask;
