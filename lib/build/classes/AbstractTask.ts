import Logger from '../../logger/Logger';

abstract class AbstractTask {
    public readonly name: string = 'Abstract Task';

    public readonly isAsync: boolean = false;

    public abstract run(): void | Promise<void>;

    protected readonly logger = Logger;
}

export default AbstractTask;
