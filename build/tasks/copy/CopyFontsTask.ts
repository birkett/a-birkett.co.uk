import { AbstractCopyFilesTask } from '@build/tasks/copy/AbstractCopyFilesTask';
import { BuildConstants } from '@build/BuildConstants';

export class CopyFontsTask extends AbstractCopyFilesTask {
    public readonly name: string = 'Copy Fonts';

    public run(): void {
        this.copyFiles(BuildConstants.fontInputDirectory, BuildConstants.fontOutputDirectory);

        this.logger.writeLine(`\t\tCopied ${this.copiedFiles} files`);
    }
}
