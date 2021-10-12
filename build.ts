import build from './lib/build/BuildSystem';
import CleanTask from './build/tasks/CleanTask';
import CopyImagesTask from './build/tasks/copy/CopyImagesTask';
import CopyFontsTask from './build/tasks/copy/CopyFontsTask';
import RenderBrowserConfigTask from './build/tasks/render/RenderBrowserConfigTask';
import RenderIndexTask from './build/tasks/render/RenderIndexTask';
import RenderWebManifestTask from './build/tasks/render/RenderWebManifestTask';
import RenderServiceWorkerTask from './build/tasks/render/RenderServiceWorkerTask';
import StylesTask from './build/tasks/StylesTask';
import SafariIconTask from './build/tasks/favIcons/SafariIconTask';
import FaviconsTask from './build/tasks/favIcons/FaviconsTask';

build({
    default: [
        new CleanTask(),
        new StylesTask(),
        new CopyImagesTask(),
        new CopyFontsTask(),
        new RenderIndexTask(),
        new SafariIconTask(),
        new RenderWebManifestTask(),
        new RenderBrowserConfigTask(),
        new RenderServiceWorkerTask(),
        new FaviconsTask(),
    ],

    fast: [new StylesTask(), new CopyImagesTask(), new RenderIndexTask()],

    clean: [new CleanTask()],
});
