import build from './lib/build/buildSystem';
import { indexTemplate, webManifest, browserConfig } from './build/tasks/renderTemplateTask';
import favIconsTask from './build/tasks/favIcons/favIconsTask';
import safariIconTask from './build/tasks/favIcons/safariIconTask';
import { images, fonts } from './build/tasks/copyFileTask';
import stylesTask from './build/tasks/stylesTask';
import cleanTask from './build/tasks/cleanTask';
import serviceWorkerTask from './build/tasks/serviceWorkerTask';

build({
    default: [
        cleanTask,
        stylesTask,
        images,
        fonts,
        indexTemplate,
        safariIconTask,
        webManifest,
        browserConfig,
        favIconsTask,
        serviceWorkerTask,
    ],

    fast: [stylesTask, images, indexTemplate],

    clean: [cleanTask],
});
