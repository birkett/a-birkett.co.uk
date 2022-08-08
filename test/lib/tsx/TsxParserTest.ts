import { suite, describe, it } from '../../../lib/test/TestSystem';
import { tsxParser } from '../../../lib/tsx/TsxParser';
import { expect } from '../../../lib/test/src/Expect';
import {
    componentWithProps,
    componentWithVoidElements,
    simpleMockComponent,
    styledComponent,
    styledLinkComponent,
    valuelessPropertyComponent,
} from './MockComponents';

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

        it('Properties with no value should be handled', () => {
            const component = tsxParser(valuelessPropertyComponent, {});

            expect(component).equal('<script async></script>');
        });
    });

    describe('Styled components', () => {
        it('Styled components should be parsed', () => {
            const component = tsxParser(styledComponent, {});

            expect(component).equal('<p style="color:#000;background-color:#FFF;">Test</p>');
        });

        it('Multiple props should be correctly spaced', () => {
            const component = tsxParser(styledLinkComponent, { environment: '#' });

            expect(component).equal(
                '<a href="#" style="color:#000;background-color:#FFF;">Test</a>',
            );
        });
    });
});
