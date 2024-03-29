import { suite, describe, it } from '@test/TestSystem';
import { expect } from '@test/Expect';
import { ElementArray } from '@tsx/ElementArray';
import { simpleMockComponent } from '@test/lib/tsx/MockComponents';

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
