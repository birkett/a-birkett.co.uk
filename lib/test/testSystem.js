const fs = require('fs');
const {
    write,
    writeLine,
    colours,
    controlCodes,
} = require('../logger/consoleWrapper');

let passedExpectations = 0;
let failedExpectations = 0;

const suite = (description, fn) => {
    write(`\n${description}`, controlCodes.bold, colours.blue);

    fn();
};

const describe = (description, fn) => {
    write(`\n\t${description}`, controlCodes.bold, colours.cyan);

    fn();
};

const it = (description, fn) => {
    write(`\n\t\t${description}\n\t\t\t`);

    fn();
};

const getFailedExpectation = () => (new Error().stack.split('at ')[3]).trim();

const expect = (value) => ({
    equal: (expected) => {
        if (value === expected) {
            write('√ ', controlCodes.bold, colours.green);
            passedExpectations += 1;

            return;
        }

        failedExpectations += 1;
        write('X \n\n', controlCodes.bold, colours.red);

        writeLine(
            `Expectation failed: ${expected} does not equal ${value}`,
            undefined,
            colours.red,
        );

        writeLine(getFailedExpectation(), undefined, colours.red);
    },
});

const test = (directory) => {
    fs.promises.readdir(directory)
        .then((files) => {
            files.forEach((file) => {
                if (file.endsWith('Test.js')) {
                    /* eslint-disable global-require */
                    /* eslint-disable import/no-dynamic-require */
                    require(`${directory}/${file}`);
                    /* eslint-enable import/no-dynamic-require */
                    /* eslint-enable global-require */
                }
            });

            writeLine(
                `\n\nPassed ${passedExpectations}, failed ${failedExpectations} expectations.\n`,
                controlCodes.bold,
                failedExpectations > 0 ? colours.red : colours.green,
            );

            process.exit(failedExpectations);
        });
};

module.exports = {
    describe,
    expect,
    it,
    suite,
    test,
};
