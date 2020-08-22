const renderTemplate = require('./build/tasks/renderTemplateTask');
const favIconsTask = require('./build/tasks/favIcons/favIconsTask');
const safariIconTask = require('./build/tasks/favIcons/safariIconTask');
const copyFiles = require('./build/tasks/copyFileTask');
const stylesTask = require('./build/tasks/stylesTask');
const cleanTask = require('./build/tasks/cleanTask');
const { runTask, runBuild } = require('./build/buildSystem');

runBuild({
    async default() {
        await runTask(cleanTask);
        await runTask(stylesTask);
        await runTask(copyFiles.images);
        await runTask(copyFiles.fonts);
        await runTask(renderTemplate.indexTemplate);
        await runTask(safariIconTask);
        await runTask(renderTemplate.webManifest);
        await runTask(renderTemplate.browserConfig);
        await runTask(favIconsTask);
    },

    async fast() {
        await runTask(stylesTask);
        await runTask(copyFiles.images);
        await runTask(renderTemplate.indexTemplate);
    },

    async clean() {
        await runTask(cleanTask);
    },
});
