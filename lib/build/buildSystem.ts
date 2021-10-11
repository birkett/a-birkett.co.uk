import { BuildJob, BuildTask } from './types/BuildJob';
import promiseInOrder from '../promise/inOrder';
import Logger from '../logger/Logger';
import ControlCode from '../logger/enum/ControlCode';
import Colour from '../logger/enum/Colour';

const runTask = async (previous: BuildTask, task: BuildTask) => {
    const startTime = Date.now();

    Logger.writeLine(`\tStarting ${task.name}`, ControlCode.Bold, Colour.Cyan);

    return new Promise(task)
        .catch((err) => {
            Logger.writeLine(err, undefined, Colour.Red);
            process.exit(1);
        })
        .then(() => {
            Logger.writeLine(
                `\t\tFinished ${task.name} in ${Date.now() - startTime}ms`,
                undefined,
                Colour.Green,
            );
        });
};

const build = (availableJobs: BuildJob) => {
    const startTime = Date.now();

    const jobName = Object.keys(availableJobs).includes(process.argv[2])
        ? process.argv[2]
        : 'default';

    Logger.writeLine(`Running job ${jobName}`, ControlCode.Bold, Colour.Blue);

    promiseInOrder(availableJobs[jobName], runTask).then(() => {
        Logger.writeLine(`Done in ${Date.now() - startTime}ms`, ControlCode.Bold, Colour.Green);
    });
};

export default build;
