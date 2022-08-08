import fs from 'fs';
import * as nunjucks from 'nunjucks';
import { BuildConstants } from '@build/BuildConstants';
import { AbstractTask } from '@build/AbstractTask';

export abstract class AbstractRenderTask extends AbstractTask {
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

        AbstractRenderTask.writeOutput(destination, renderedTemplate);
    }

    protected static writeOutput(destination: string, renderedTemplate: string): void {
        fs.writeFileSync(destination, renderedTemplate);
    }
}
