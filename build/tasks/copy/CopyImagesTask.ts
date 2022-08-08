import { AbstractCopyFilesTask } from '@build/tasks/copy/AbstractCopyFilesTask';
import { BuildConstants } from '@build/BuildConstants';

export class CopyImagesTask extends AbstractCopyFilesTask {
    public readonly name: string = 'Copy Images';

    public run(): void {
        this.copyFiles(BuildConstants.svgInputDirectory, BuildConstants.imgOutputDirectory);

        this.logger.writeLine(`\t\tCopied ${this.copiedFiles} files`);
    }
}
