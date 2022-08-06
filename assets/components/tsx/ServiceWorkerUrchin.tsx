import fs from 'fs';
import h, { FunctionComponent } from '../../../lib/tsx/TsxParser';
import BuildConstants from '../../../build/BuildConstants';

interface UrchinProps {
    gitRevision: string;
}

const getSerivceWorkerUrchinScript = (gitRevision: string): string => {
    const content = fs.readFileSync(BuildConstants.serviceWorkerUrchinFileName);

    const replaceContent = content.toString().replace('{ gitRevision }', gitRevision);

    // Remove comments from the script.
    return replaceContent.replace(/\/\*.+?\*\/|\/\/.*(?=[\n\r])/g, '');
};

const ServiceWorkerUrchin: FunctionComponent<UrchinProps> = (props: UrchinProps) => {
    const { gitRevision } = props;

    const scriptContent = getSerivceWorkerUrchinScript(gitRevision);

    return <script type="text/javascript">{scriptContent}</script>;
};

export default ServiceWorkerUrchin;
