const { log } = console;

const runTask = async (task) => {
    const startTime = Date.now();

    log(`Starting ${task.name}`);

    return new Promise(task)
        .catch((err) => {
            log(err);
            process.exit(1);
        })
        .then(() => log(`Finished ${task.name} in ${Date.now() - startTime}ms`));
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

    log(`Running job ${jobName}`);

    runJobSeries(availableJobs[jobName])
        .then(() => log(`Done in ${Date.now() - startTime}ms`));
};

module.exports = build;
