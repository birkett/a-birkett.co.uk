import { AbstractCopyFilesTask } from './AbstractCopyFilesTask';
import { BuildConstants } from '../../BuildConstants';

export class CopyImagesTask extends AbstractCopyFilesTask {
    public readonly name: string = 'Copy Images';

    public run(): void {
        this.copyFiles(BuildConstants.svgInputDirectory, BuildConstants.imgOutputDirectory);

        this.logger.writeLine(`\t\tCopied ${this.copiedFiles} files`);
    }
}
