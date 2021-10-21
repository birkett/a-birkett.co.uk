import Logger from '../logger/Logger';
import ControlCode from '../logger/enum/ControlCode';
import Colour from '../logger/enum/Colour';
import AbstractTask from './classes/AbstractTask';

type BuildJob = Record<string, AbstractTask[]>;

const runTask = (job: AbstractTask) => {
    const startTime = Date.now();

    Logger.writeLine(`\tStarting ${job.name}`, ControlCode.Bold, Colour.Cyan);

    try {
        job.run();
    } catch (exception) {
        Logger.error(exception as string);

        process.exit(1);
    }

    Logger.writeLine(
        `\t\tFinished ${job.name} in ${Date.now() - startTime}ms`,
        undefined,
        Colour.Green,
    );
};

const build = (availableJobs: BuildJob) => {
    const startTime = Date.now();

    const jobName = Object.keys(availableJobs).includes(process.argv[2])
        ? process.argv[2]
        : 'default';

    Logger.writeLine(`Running job ${jobName}`, ControlCode.Bold, Colour.Blue);

    availableJobs[jobName].forEach((job) => runTask(job));

    process.on('exit', () => {
        Logger.writeLine(`Done in ${Date.now() - startTime}ms`, ControlCode.Bold, Colour.Green);
    });
};

export default build;
