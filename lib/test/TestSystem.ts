import * as fs from 'fs';
import { getFailedExpectations, getPassedExpectations } from '@test/PassFail';
import { Output } from '@test/Output';
import { readDirSyncDeep } from '@fs/readDirDeep';

export const suite = (description: string, fn: VoidFunction) => {
    Output.suiteDescription(description);

    fn();
};

export const describe = (description: string, fn: VoidFunction) => {
    Output.describeDescription(description);

    fn();
};

export const it = (description: string, fn: VoidFunction) => {
    Output.caseDescription(description);

    fn();
};

const runTests = (files: string[]) => {
    const startTime = Date.now();

    files.forEach((file) => {
        if (file.endsWith('Test.ts')) {
            /* eslint-disable import/no-dynamic-require */
            /* eslint-disable global-require */
            require(fs.realpathSync(file));
            /* eslint-enable global-require */
            /* eslint-enable import/no-dynamic-require */
        }
    });

    const passedText = `\n\nPassed ${getPassedExpectations()},`;
    const failedText = `failed ${getFailedExpectations()} expectations.`;
    const timeText = `Took ${Date.now() - startTime}ms.\n`;

    Output.testSummary(`${passedText} ${failedText} ${timeText}`, getFailedExpectations());

    process.exit(getFailedExpectations());
};

export const testSuite = () => {
    const argument = process.argv[2];

    if (!argument) {
        runTests(readDirSyncDeep('test'));

        return;
    }

    if (argument.endsWith('.ts')) {
        runTests([argument]);
    }
};
