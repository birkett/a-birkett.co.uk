import fs from 'fs';
import BuildConstants from '../../buildConstants';
import AbstractTask from '../../../lib/build/classes/AbstractTask';

const nunjucks = require('nunjucks');

abstract class AbstractRenderTask extends AbstractTask {
    protected readonly templateConstantsPath = BuildConstants.templateConstantsJsonPath;

    protected static loadJson(path: string): object {
        return JSON.parse(fs.readFileSync(path).toString());
    }

    protected renderFile(source: string, destination: string, additionalData?: {}): void {
        const data = {
            constants: {
                ...AbstractRenderTask.loadJson(this.templateConstantsPath),
                ...BuildConstants,
            },
            ...additionalData,
        };

        const renderedTemplate = nunjucks.render(source, data);

        fs.writeFileSync(destination, renderedTemplate);
    }
}

export default AbstractRenderTask;
