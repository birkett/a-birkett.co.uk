import h from '../../../lib/tsx/TsxParser';

export const simpleMockComponent = (): JSX.Element => <h1>It Works!</h1>;

interface ComponentProps {
    environment: string;
}

export const componentWithProps = (props: Partial<ComponentProps>): JSX.Element => (
    <div>
        <h1>{props.environment}</h1>

        {props.environment}
    </div>
);
