import { Output, Stringable } from './Output';

const getFailedExpectation = () => new Error().stack!.split('at ')[4].trim();

let passedExpectations = 0;
let failedExpectations = 0;

export const passExpectation = (): void => {
    Output.passedExpectation();
    passedExpectations += 1;
};

export const failedExpectation = (expected: Stringable, value: Stringable): void => {
    Output.failedExpectation(getFailedExpectation(), expected, value);

    failedExpectations += 1;
};

export const getPassedExpectations = (): number => passedExpectations;

export const getFailedExpectations = (): number => failedExpectations;
