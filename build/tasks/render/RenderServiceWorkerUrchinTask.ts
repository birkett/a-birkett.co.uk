import { BuildConstants } from '@build/BuildConstants';
import { AbstractRenderTask } from '@build/tasks/render/AbstractRenderTask';

export class RenderServiceWorkerUrchinTask extends AbstractRenderTask {
    public readonly name: string = 'Render Service Worker Urchin';

    public run(): void {
        this.renderFile(
            BuildConstants.serviceWorkerUrchinInputFileName,
            BuildConstants.serviceWorkerUrchinOutputPath,
        );
    }
}
