import { AbstractRenderTask } from './AbstractRenderTask';
import { BuildConstants } from '../../BuildConstants';

export class RenderWebManifestTask extends AbstractRenderTask {
    public readonly name: string = 'Render Web Manifest';

    public run(): void {
        this.renderFile(
            BuildConstants.webManifestInputFileName,
            BuildConstants.webManifestOutputFileName,
        );
    }
}
