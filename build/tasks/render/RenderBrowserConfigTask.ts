import { AbstractRenderTask } from '@build/tasks/render/AbstractRenderTask';
import { BuildConstants } from '@build/BuildConstants';

export class RenderBrowserConfigTask extends AbstractRenderTask {
    public readonly name: string = 'Render Browser Config';

    public run(): void {
        this.renderFile(
            BuildConstants.browserConfigInputFileName,
            BuildConstants.browserConfigOutputFileName,
        );
    }
}
