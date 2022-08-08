import { Logger } from '@logger/Logger';

export abstract class AbstractTask {
    public readonly name: string = 'Abstract Task';

    public abstract run(): void;

    protected readonly logger = Logger;
}
