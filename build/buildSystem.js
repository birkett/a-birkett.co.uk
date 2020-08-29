/* eslint-disable no-console */
const writeLine = (line) => console.log(line);
/* eslint-enable no-console */

const runTask = async (task) => {
    const startTime = Date.now();

    writeLine(`Starting ${task.name}`);

    return new Promise(task)
        .catch((err) => {
            writeLine(err);
            process.exit(1);
        })
        .then(() => writeLine(`Finished ${task.name} in ${Date.now() - startTime}ms`));
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

    writeLine(`Running job ${jobName}`);

    runJobSeries(availableJobs[jobName])
        .then(() => writeLine(`Done in ${Date.now() - startTime}ms`));
};

module.exports = build;
