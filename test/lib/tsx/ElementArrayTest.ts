import { suite, describe, it } from '../../../lib/test/TestSystem';
import { expect } from '../../../lib/test/src/Expect';
import { ElementArray } from '../../../lib/tsx/ElementArray';
import { simpleMockComponent } from './MockComponents';

suite('ElementArray', () => {
    describe('Basic functionality', () => {
        it('Should join with empty string', () => {
            const elements = new ElementArray();

            elements.push(simpleMockComponent());
            elements.push(simpleMockComponent());

            const componentString = elements.toString();

            expect(componentString).equal('<h1>It Works!</h1><h1>It Works!</h1>');
        });
    });
});
