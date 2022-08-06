import { suite, describe, it } from '../../../lib/test/TestSystem';
import tsxParser from '../../../lib/tsx/TsxParser';
import {
    componentWithProps,
    componentWithVoidElements,
    simpleMockComponent,
    styledComponent,
} from './MockComponents';
import expect from '../../../lib/test/src/Expect';

suite('TsxParser', () => {
    describe('Basic functionality', () => {
        it('Should parse a simple functional component', () => {
            const componentString = tsxParser(simpleMockComponent, {});

            expect(componentString).equal('<h1>It Works!</h1>');
        });

        it('Should parse a component with props', () => {
            const componentString = tsxParser(componentWithProps, { environment: 'Test' });

            expect(componentString).equal('<div><h1>Test</h1>Test</div>');
        });
    });

    describe('Void element handling', () => {
        it('Void elements should be self closing', () => {
            const metaComponent = tsxParser(componentWithVoidElements, {});

            expect(metaComponent).equal('<meta http-equiv="Content-Type" />');
        });

        it('Styled components should be parsed', () => {
            const component = tsxParser(styledComponent, {});

            expect(component).equal('<p style="color:#000;background-color:#FFF;">Test</p>');
        });
    });
});
