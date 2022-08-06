import * as fs from 'fs';
import * as sass from 'sass';
import { BuildConstants } from '../BuildConstants';
import { AbstractTask } from '../../lib/build/classes/AbstractTask';

export class StylesTask extends AbstractTask {
    public readonly name: string = 'Build Styles';

    private readonly inputScss = 'main.scss';

    private readonly outputCss = 'main.css';

    public run(): void {
        const scss = fs.readFileSync(`${BuildConstants.scssInputDirectory}${this.inputScss}`);
        const outputStyle = 'compressed' as 'compressed';

        const sassOptions = {
            outputStyle,
            includePaths: [BuildConstants.scssInputDirectory],
            data: `$gitRevision: '${BuildConstants.gitRevision()}'; ${scss}`,
        };

        const renderResult = sass.renderSync(sassOptions);

        fs.mkdirSync(BuildConstants.cssOutputDirectory);

        const css = renderResult.css.toString();

        fs.writeFileSync(`${BuildConstants.cssOutputDirectory}${this.outputCss}`, css);
    }
}
