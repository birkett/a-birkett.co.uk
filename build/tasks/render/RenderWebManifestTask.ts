import { AbstractRenderTask } from '@build/tasks/render/AbstractRenderTask';
import { BuildConstants } from '@build/BuildConstants';

export class RenderWebManifestTask extends AbstractRenderTask {
    public readonly name: string = 'Render Web Manifest';

    public run(): void {
        this.renderFile(
            BuildConstants.webManifestInputFileName,
            BuildConstants.webManifestOutputFileName,
        );
    }
}
