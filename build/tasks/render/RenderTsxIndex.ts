import { tsxParser } from '../../../lib/tsx/TsxParser';
import { Base, BaseProps } from '../../../assets/components/tsx/Base';
import { AbstractRenderTask } from './AbstractRenderTask';
import { BuildConstants } from '../../BuildConstants';
import { LinkProps } from '../../../assets/components/tsx/Header';
import { TagGroups } from '../../../assets/components/tsx/TagCloud';

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
            links: links as [],
            msTileColor: BuildConstants.msTileColor,
            faviconPrefix: BuildConstants.faviconPrefix,
            themeColor: BuildConstants.themeColor,
            webManifestFileName: BuildConstants.webManifestFileName,
            safariIconFileName: BuildConstants.safariIconFileName,
            fontFileName: BuildConstants.fontFileName,
            outputCssFileName: BuildConstants.outputCssFileName,
            baseUrl: templateConstants.baseUrl,
            tagGroups,
        };

        return tsxParser(Base, props) as string;
    }

    private addDoctype(content: string): string {
        return `${this.contentType}${content}`;
    }
}
