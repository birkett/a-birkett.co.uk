import AbstractCopyFilesTask from './AbstractCopyFilesTask';
import BuildConstants from '../../BuildConstants';

class CopyFontsTask extends AbstractCopyFilesTask {
    public readonly name: string = 'Copy Fonts';

    public run(): void {
        this.copyFiles(BuildConstants.fontInputDirectory, BuildConstants.fontOutputDirectory);

        this.logger.writeLine(`\t\tCopied ${this.copiedFiles} files`);
    }
}

export default CopyFontsTask;
