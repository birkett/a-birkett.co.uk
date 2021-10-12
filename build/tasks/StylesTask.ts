import * as fs from 'fs';
import BuildConstants from '../BuildConstants';
import AbstractTask from '../../lib/build/classes/AbstractTask';

const sass = require('sass');

class StylesTask extends AbstractTask {
    public readonly name: string = 'Build Styles';

    private readonly inputScss = 'main.scss';

    private readonly outputCss = 'main.css';

    private readonly outputStyle = 'compressed';

    public run(): void {
        const scss = fs.readFileSync(`${BuildConstants.scssInputDirectory}${this.inputScss}`);

        const sassOptions = {
            outputStyle: this.outputStyle,
            includePaths: [BuildConstants.scssInputDirectory],
            data: `$gitRevision: '${BuildConstants.gitRevision()}'; ${scss}`,
        };

        const renderResult = sass.renderSync(sassOptions);

        fs.mkdirSync(BuildConstants.cssOutputDirectory);

        const css = renderResult.css.toString();

        fs.writeFileSync(`${BuildConstants.cssOutputDirectory}${this.outputCss}`, css);
    }
}

export default StylesTask;
