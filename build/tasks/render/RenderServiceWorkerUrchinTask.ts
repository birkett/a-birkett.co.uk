import { BuildConstants } from '../../BuildConstants';
import { AbstractRenderTask } from './AbstractRenderTask';

export class RenderServiceWorkerUrchinTask extends AbstractRenderTask {
    public readonly name: string = 'Render Service Worker Urchin';

    public run(): void {
        this.renderFile(
            BuildConstants.serviceWorkerUrchinInputFileName,
            BuildConstants.serviceWorkerUrchinOutputPath,
        );
    }
}
