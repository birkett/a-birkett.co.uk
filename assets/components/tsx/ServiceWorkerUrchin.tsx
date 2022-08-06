import fs from 'fs';
import h from '../../../lib/tsx/TsxParser';
import BuildConstants from '../../../build/BuildConstants';

interface ServiceWorkerUrchinProps {
    gitRevision: string;
}

const getSerivceWorkerUrchinScript = (gitRevision: string): string => {
    const content = fs.readFileSync(BuildConstants.serviceWorkerUrchinFileName);

    const replaceContent = content.toString().replace('{ gitRevision }', gitRevision);

    // Remove comments from the script.
    return replaceContent.replace(/\/\*.+?\*\/|\/\/.*(?=[\n\r])/g, '');
};

function ServiceWorkerUrchin(props: ServiceWorkerUrchinProps): JSX.Element {
    const { gitRevision } = props;

    const scriptContent = getSerivceWorkerUrchinScript(gitRevision);

    return <script type="text/javascript">{scriptContent}</script>;
}

export default ServiceWorkerUrchin;
