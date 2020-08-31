const fs = require('fs');

const { log } = console;

let passedExpectations = 0;
let failedExpectations = 0;

const describe = (description, fn) => {
    process.stdout.write(`\n${description}`);

    fn();
};

const it = (description, fn) => {
    process.stdout.write(`\n\t${description}\n\t\t`);

    fn();
};

const getFailedExpectation = () => (new Error().stack.split('at ')[3]).trim();

const expect = (value) => ({
    equal: (expected) => {
        if (value === expected) {
            process.stdout.write('√');
            passedExpectations += 1;

            return;
        }

        failedExpectations += 1;
        process.stdout.write('X\n\n');
        log(`Expectation failed: ${expected} does not equal ${value}`);
        log(getFailedExpectation());
    },
});

const test = (directory) => {
    fs.promises.readdir(directory)
        .then((files) => {
            files.forEach((file) => {
                if (file.endsWith('Test.js')) {
                    /* eslint-disable global-require */
                    /* eslint-disable import/no-dynamic-require */
                    require(`../${directory}${file}`);
                    /* eslint-enable import/no-dynamic-require */
                    /* eslint-enable global-require */
                }
            });

            process.stdout.write(
                `\n\nPassed ${passedExpectations}, failed ${failedExpectations} expectations.\n`,
            );

            process.exit(failedExpectations);
        });
};

module.exports = {
    describe,
    expect,
    it,
    test,
};
