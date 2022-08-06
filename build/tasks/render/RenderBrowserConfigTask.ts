import { AbstractRenderTask } from './AbstractRenderTask';
import { BuildConstants } from '../../BuildConstants';

export class RenderBrowserConfigTask extends AbstractRenderTask {
    public readonly name: string = 'Render Browser Config';

    public run(): void {
        this.renderFile(
            BuildConstants.browserConfigInputFileName,
            BuildConstants.browserConfigOutputFileName,
        );
    }
}
