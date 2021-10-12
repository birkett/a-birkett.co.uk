import * as fs from 'fs';
import BuildConstants from '../../BuildConstants';
import AbstractTask from '../../../lib/build/classes/AbstractTask';

class SafariIconTask extends AbstractTask {
    public readonly name: string = 'Safari Icon';

    private readonly fillRegex = 'fill="#(.*?)"';

    private readonly fillValue = 'fill="#000000"';

    public run(): void {
        const data = fs.readFileSync(BuildConstants.faviconInputFile);
        const replaceRegex = new RegExp(this.fillRegex, 'g');
        const outputData = data.toString().replace(replaceRegex, this.fillValue);

        fs.writeFileSync(BuildConstants.safariIconOutputFileName, outputData);
    }
}

export default SafariIconTask;
