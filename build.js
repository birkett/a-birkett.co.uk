const renderTemplate = require('./build/tasks/renderTemplateTask');
const favIconsTask = require('./build/tasks/favIcons/favIconsTask');
const safariIconTask = require('./build/tasks/favIcons/safariIconTask');
const copyFiles = require('./build/tasks/copyFileTask');
const stylesTask = require('./build/tasks/stylesTask');
const cleanTask = require('./build/tasks/cleanTask');
const serviceWorkerTask = require('./build/tasks/serviceWorkerTask');
const build = require('./lib/build/buildSystem');

build({
    default: [
        cleanTask,
        stylesTask,
        copyFiles.images,
        copyFiles.fonts,
        renderTemplate.indexTemplate,
        safariIconTask,
        renderTemplate.webManifest,
        renderTemplate.browserConfig,
        favIconsTask,
        serviceWorkerTask,
    ],

    fast: [
        stylesTask,
        copyFiles.images,
        renderTemplate.indexTemplate,
    ],

    clean: [
        cleanTask,
    ],
});
