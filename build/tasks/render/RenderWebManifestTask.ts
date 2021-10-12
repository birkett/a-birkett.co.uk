import AbstractRenderTask from './AbstractRenderTask';
import BuildConstants from '../../BuildConstants';

class RenderWebManifestTask extends AbstractRenderTask {
    public readonly name: string = 'Render Web Manifest';

    public run(): void {
        this.renderFile(
            BuildConstants.webManifestInputFileName,
            BuildConstants.webManifestOutputFileName,
        );
    }
}

export default RenderWebManifestTask;
