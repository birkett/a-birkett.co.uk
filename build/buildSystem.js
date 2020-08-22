function writeLine(line) {
    /* eslint-disable no-console */
    console.log(line);
    /* eslint-enable no-console */
}

module.exports = {
    async runTask(task) {
        const startTime = Date.now();

        writeLine(`Starting ${task.name}`);

        await new Promise(task)
            .catch((err) => {
                writeLine(err);
                process.exit(1);
            })
            .then(() => {
                const endTime = Date.now();

                writeLine(`Finished ${task.name} in ${endTime - startTime}ms`);
            });
    },

    runBuild(availableJobs) {
        const startTime = Date.now();

        const jobName = Object.keys(availableJobs).includes(process.argv[2])
            ? process.argv[2]
            : 'default';

        writeLine(`Running job ${jobName}`);

        availableJobs[jobName]().then(() => {
            const endTime = Date.now();

            writeLine(`Done in ${endTime - startTime}ms`);
        });
    },
};
