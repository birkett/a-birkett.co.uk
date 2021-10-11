import { equalObjects, equalPrimitives, isObject } from './Equals';
import { failedExpectation, passExpectation } from './PassFail';

const expect = (value: any) => ({
    equal: (expected: any) => {
        const areBothObjects = isObject(value) && isObject(expected);
        const result = areBothObjects
            ? equalObjects(value, expected)
            : equalPrimitives(value, expected);

        if (result) {
            passExpectation();

            return;
        }

        failedExpectation(expected, value);
    },
});

export default expect;
