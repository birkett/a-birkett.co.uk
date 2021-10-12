import * as fs from 'fs';
import BuildConstants from '../BuildConstants';
import AbstractTask from '../../lib/build/classes/AbstractTask';

class CleanTask extends AbstractTask {
    public readonly name: string = 'Clean';

    public run(): void {
        try {
            fs.statSync(BuildConstants.outputDirectory);
        } catch {
            this.logger.writeLine('\t\tOutput directory does not exist, creating new one');

            fs.mkdirSync(BuildConstants.outputDirectory);

            return;
        }

        this.logger.writeLine('\t\tOutput directory exists, re-creating');
        fs.rmSync(BuildConstants.outputDirectory, { recursive: true });
        fs.mkdirSync(BuildConstants.outputDirectory);
    }
}

export default CleanTask;
