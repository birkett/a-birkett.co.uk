import { ControlCode } from '@logger/ControlCode';
import { Colour } from '@logger/Colour';

export class Logger {
    public static writeLine(
        message: string,
        controlCode: ControlCode | null = null,
        fgColour: Colour | null = null,
    ): void {
        const { log } = console;

        log(`${controlCode || ''}${fgColour || ''}${message}${ControlCode.Reset}`);
    }

    public static write(
        message: string,
        controlCode: ControlCode | null = null,
        fgColour: Colour | null = null,
    ): void {
        process.stdout.write(`${controlCode || ''}${fgColour || ''}${message}${ControlCode.Reset}`);
    }

    public static error(message: string, bold: boolean = false): void {
        Logger.writeLine(message, bold ? ControlCode.Bold : null, Colour.Red);
    }

    public static info(message: string, bold: boolean = false): void {
        Logger.writeLine(message, bold ? ControlCode.Bold : null);
    }
}
