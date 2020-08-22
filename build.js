const { browserConfigTask, indexTemplateTask, webManifestTask } = require('./build/tasks/renderTemplateTask');
const favIconsTask = require('./build/tasks/favIcons/favIconsTask');
const safariIconTask = require('./build/tasks/favIcons/safariIconTask');
const { fontsTask, imagesTask } = require('./build/tasks/copyFileTask');
const stylesTask = require('./build/tasks/stylesTask');
const cleanTask = require('./build/tasks/cleanTask');
const { runTask, runBuild } = require('./build/buildSystem');

runBuild({
    async default() {
        await runTask(cleanTask);
        await runTask(stylesTask);
        await runTask(imagesTask);
        await runTask(fontsTask);
        await runTask(indexTemplateTask);
        await runTask(safariIconTask);
        await runTask(webManifestTask);
        await runTask(browserConfigTask);
        await runTask(favIconsTask);
    },

    async fast() {
        await runTask(stylesTask);
        await runTask(imagesTask);
        await runTask(indexTemplateTask);
    },

    async clean() {
        await runTask(cleanTask);
    },
});
