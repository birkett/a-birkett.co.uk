import { suite, describe, it } from '../lib/test/TestSystem';
import expect from '../lib/test/src/Expect';
import memoize from '../lib/memoize/memoize';

suite('Memoize', () => {
    describe('Basic functionality', () => {
        it('Should cache the result of a function across multiple calls', () => {
            let numberOfRawFuncCalls = 0;

            const rawFunc = () => {
                numberOfRawFuncCalls += 1;

                return 1337;
            };

            const cachedCall = memoize(() => rawFunc());

            const result1 = cachedCall();
            const result2 = cachedCall();
            const result3 = cachedCall();

            expect(result1).equal(result2);
            expect(result1).equal(result3);
            expect(numberOfRawFuncCalls).equal(1);
        });
    });
});
