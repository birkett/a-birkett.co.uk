import AbstractRenderTask from './AbstractRenderTask';
import BuildConstants from '../../buildConstants';

class RenderIndex extends AbstractRenderTask {
    public readonly name: string = 'Render Index';

    public run(): void {
        this.renderFile(
            BuildConstants.templateInputFileName,
            BuildConstants.templateOutputFileName,
            {
                links: AbstractRenderTask.loadJson(BuildConstants.headerLinksJsonPath),
                tagGroups: AbstractRenderTask.loadJson(BuildConstants.tagsJsonPath),
            },
        );
    }
}

export default RenderIndex;
