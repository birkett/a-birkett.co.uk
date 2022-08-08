import { Logger } from '@logger/Logger';
import { ControlCode } from '@logger/ControlCode';
import { Colour } from '@logger/Colour';

export interface Stringable {
    toString: () => string;
}

export class Output {
    public static passedExpectation(): void {
        Logger.write('√ ', ControlCode.Bold, Colour.Green);
    }

    public static failedExpectation(trace: string, expected: Stringable, value: Stringable): void {
        Logger.write('X \n\n', ControlCode.Bold, Colour.Red);

        Logger.error(`Expectation failed: ${expected} does not equal ${value}`);

        Logger.error(trace);
    }

    public static suiteDescription(description: string): void {
        Logger.write(`\n${description}`, ControlCode.Bold, Colour.Blue);
    }

    public static describeDescription(description: string): void {
        Logger.write(`\n\t${description}`, ControlCode.Bold, Colour.Cyan);
    }

    public static caseDescription(description: string): void {
        Logger.write(`\n\t\t${description}\n\t\t\t`);
    }

    public static testSummary(summary: string, failed: number): void {
        Logger.writeLine(summary, ControlCode.Bold, failed > 0 ? Colour.Red : Colour.Green);
    }
}
