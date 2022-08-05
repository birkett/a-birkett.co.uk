import tsxParser from '../../../lib/tsx/TsxParser';
import Base, { BaseProps } from '../../../assets/components/tsx/Base';
import AbstractRenderTask from './AbstractRenderTask';
import BuildConstants from '../../BuildConstants';
import { LinkProps } from '../../../assets/components/tsx/Header';

class RenderTsxIndex extends AbstractRenderTask {
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
        ) as Partial<BaseProps>;

        const buildConstants = BuildConstants as Partial<BaseProps>;

        const links = AbstractRenderTask.loadJson(
            BuildConstants.headerLinksJsonPath,
        ) as LinkProps[];

        // AbstractRenderTask.loadJson(BuildConstants.tagsJsonPath);

        const props = {
            firstName: templateConstants.firstName,
            lastName: templateConstants.lastName,
            gitRevision: BuildConstants.gitRevision(),
            githubLink: templateConstants.githubLink,
            links: links as [],
            msTileColor: buildConstants.msTileColor,
            faviconPrefix: buildConstants.faviconPrefix,
            themeColor: buildConstants.themeColor,
            webManifestFileName: buildConstants.webManifestFileName,
            safariIconFileName: buildConstants.safariIconFileName,
            fontFileName: buildConstants.fontFileName,
            outputCssFileName: buildConstants.outputCssFileName,
            baseUrl: templateConstants.baseUrl,
        };

        return tsxParser(Base, props) as string;
    }

    private addDoctype(content: string): string {
        return `${this.contentType}${content}`;
    }
}

export default RenderTsxIndex;
