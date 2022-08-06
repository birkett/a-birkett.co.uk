import h, { FunctionComponent } from '../../../lib/tsx/TsxParser';

interface AboutProps {
    firstName: string;
}

export const About: FunctionComponent<AboutProps> = (props: AboutProps) => {
    const { firstName } = props;

    return (
        <section>
            <h2>A driven individual with a deep interest in the IT Industry from a young age</h2>

            <p>
                Currently enjoying working as a multilingual Developer for a large company.
                Previously ran his own IT services company, building custom solutions and support
                packages for customers.
            </p>
            <p>
                When not working on something electronic or covered in engine oil, {firstName}{' '}
                enjoys all things Mountain Bike related, Golf and has an obsession with Formula 1.
            </p>
            <p>
                He builds, fabricates, takes apart, fixes and tweaks - be it cars, furniture,
                buildings, or anything in between.
            </p>

            <br />

            <p>He also has no problem speaking of himself in the third person.</p>
        </section>
    );
};
