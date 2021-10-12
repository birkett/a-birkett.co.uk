import fs from 'fs';
import AbstractTask from '../../../lib/build/classes/AbstractTask';

abstract class AbstractCopyFilesTask extends AbstractTask {
    protected copiedFiles = 0;

    protected copyFiles(sourceDir: string, destinationDir: string) {
        const files = fs.readdirSync(sourceDir);

        fs.mkdirSync(destinationDir);

        files.forEach((file) => {
            const copySource = `${sourceDir}${file}`;
            const copyDest = `${destinationDir}${file}`;

            fs.copyFileSync(copySource, copyDest);

            this.copiedFiles += 1;
        });
    }
}

export default AbstractCopyFilesTask;
