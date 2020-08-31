const { writeLine, controlCodes, colours } = require('../logger/consoleWrapper');

const runTask = async (task) => {
    const startTime = Date.now();

    writeLine(`\tStarting ${task.name}`, controlCodes.bold, colours.cyan);

    return new Promise(task)
        .catch((err) => {
            writeLine(err, undefined, colours.red);
            process.exit(1);
        })
        .then(() => writeLine(
            `\t\tFinished ${task.name} in ${Date.now() - startTime}ms`,
            undefined,
            colours.green,
        ));
};

const runJobSeries = async (tasks) => tasks.reduce(async (previous, next) => {
    await previous;

    return runTask(next);
}, Promise.resolve());

const build = (availableJobs) => {
    const startTime = Date.now();

    const jobName = Object.keys(availableJobs).includes(process.argv[2])
        ? process.argv[2]
        : 'default';

    writeLine(`Running job ${jobName}`, controlCodes.bold, colours.blue);

    runJobSeries(availableJobs[jobName])
        .then(() => writeLine(
            `Done in ${Date.now() - startTime}ms`,
            controlCodes.bold,
            colours.green,
        ));
};

module.exports = build;
