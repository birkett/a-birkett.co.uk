import h, { FunctionComponent } from '@tsx/TsxParser';

interface AboutProps {
    firstName: string;
}

export const About: FunctionComponent<AboutProps> = (props: AboutProps) => {
    const { firstName } = props;

    return (
        <section>
            <h2>
                A driven individual with a deep interest in multiple areas of the the IT Industry
            </h2>

            <p>
                Currently enjoying working as a multilingual Developer and Development Manager for a
                large company; building bespoke CAD software, CRM and other internal applications.
                {firstName} previously ran his own IT services company, building custom solutions
                and support packages for customers.
            </p>

            <p>
                When not working on something electronic or mechanical, he enjoys all things
                Mountain Bike related, has an obsession with Formula 1, and considers Heist movies
                the genre of choice.
            </p>

            <p>
                He builds, fabricates, takes apart, modifies, fixes and tweaks - be it computers,
                cars, furniture, buildings, or anything in between.
            </p>

            <br />

            <p>He also has no problem speaking of himself in the third person.</p>
        </section>
    );
};
