import { suite, describe, it } from '../../../lib/test/TestSystem';
import tsxParser, { textAddSpaces } from '../../../lib/tsx/TsxParser';
import { componentWithProps, simpleMockComponent } from './MockComponents';
import expect from '../../../lib/test/src/Expect';

suite('TsxParser', () => {
    describe('Basic functionality', () => {
        it('Should parse a simple functional component', () => {
            const componentString = tsxParser(simpleMockComponent);

            expect(componentString).equal('<h1>It Works!</h1>');
        });

        it('Should parse a component with props', () => {
            const componentString = tsxParser(componentWithProps, { environment: 'Test' });

            expect(componentString).equal('<div><h1>Test</h1>Test</div>');
        });
    });

    describe('Text padding', () => {
        it('Should add non breaking space tags to strings', () => {
            const string = textAddSpaces('Test');

            expect(string).equal('&nbspTest&nbsp');
        });
    });
});
