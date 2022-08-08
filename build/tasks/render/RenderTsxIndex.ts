import { tsxParser } from '@tsx/TsxParser';
import { Base, BaseProps } from '@components/Base';
import { AbstractRenderTask } from '@build/tasks/render/AbstractRenderTask';
import { BuildConstants } from '@build/BuildConstants';
import { LinkProps } from '@components/Link';
import { TagGroups } from '@components/TagCloud';

export class RenderTsxIndex extends AbstractRenderTask {
    public readonly name: string = 'Render TSX Index';

    private readonly contentType: string = '<!DOCTYPE html>';

    public run(): void {
        const content = this.renderTsx();

        AbstractRenderTask.writeOutput(
            BuildConstants.templateOutputFileName,
            this.addDoctype(content),
        );
    }

    private renderTsx(): string {
        const templateConstants = AbstractRenderTask.loadJson(
            this.templateConstantsPath,
        ) as BaseProps;

        const links = AbstractRenderTask.loadJson(
            BuildConstants.headerLinksJsonPath,
        ) as LinkProps[];

        const tagGroups = AbstractRenderTask.loadJson(BuildConstants.tagsJsonPath) as TagGroups;

        const props: BaseProps = {
            firstName: templateConstants.firstName,
            lastName: templateConstants.lastName,
            gitRevision: BuildConstants.gitRevision(),
            githubLink: templateConstants.githubLink,
            links,
            msTileColor: BuildConstants.msTileColor,
            faviconPrefix: BuildConstants.faviconPrefix,
            themeColor: BuildConstants.themeColor,
            webManifestFileName: BuildConstants.webManifestFileName,
            safariIconFileName: BuildConstants.safariIconFileName,
            fontFileName: BuildConstants.fontFileName,
            outputCssFileName: BuildConstants.outputCssFileName,
            baseUrl: templateConstants.baseUrl,
            tagGroups,
            serviceWorkerUrchinFileName: BuildConstants.serviceWorkerUrchinOutputFileName,
        };

        return tsxParser(Base, props) as string;
    }

    private addDoctype(content: string): string {
        return `${this.contentType}${content}`;
    }
}
