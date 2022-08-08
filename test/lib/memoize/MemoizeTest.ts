import { suite, describe, it } from '@test/TestSystem';
import { expect } from '@test/Expect';
import { memoize } from '@memoize/Memoize';

suite('Memoize', () => {
    describe('Basic functionality', () => {
        it('Should cache the result of a function across multiple calls', () => {
            let numberOfRawFuncCalls = 0;

            const rawFunc = (): number => {
                numberOfRawFuncCalls += 1;

                return 1337;
            };

            const cachedCall = memoize<number>((): number => rawFunc());

            const result1 = cachedCall();
            const result2 = cachedCall();
            const result3 = cachedCall();

            expect(result1).equal(result2);
            expect(result1).equal(result3);
            expect(numberOfRawFuncCalls).equal(1);
        });
    });
});
