export type FunctionComponent<PropsType> = (props: PropsType) => JSX.Element;
type StringRecord = Record<string, string>;

const propertyRewrites: StringRecord = {
    httpEquiv: 'http-equiv',
    className: 'class',
    backgroundColor: 'background-color',
};

const voidElements: StringRecord = {
    meta: 'meta',
    link: 'link',
    br: 'br',
};

const parseStyledComponent = (styles: StringRecord): string => {
    let styleString = '';

    Object.keys(styles).forEach((styleKey) => {
        styleString += `${propertyRewrites[styleKey] || styleKey}:${styles[styleKey]};`;
    });

    return `style="${styleString}"`;
};

const parseNode = <PropsType>(element: string, properties: PropsType, children: string[]) => {
    let elementString = `<${element}`;
    const typedProperties = properties as unknown as StringRecord;

    if (properties) {
        const props: string[] = [];
        elementString += ' ';

        Object.keys(properties).forEach((property) => {
            if (property === 'style') {
                props.push(
                    parseStyledComponent(typedProperties[property] as unknown as StringRecord),
                );

                return;
            }

            const replacedProperty = propertyRewrites[property] || property;

            props.push(`${replacedProperty}="${typedProperties[property]}"`);
        });

        elementString += props.join(' ');
    }

    elementString += voidElements[element] ? ' />' : '>';

    children.forEach((child) => {
        elementString += child;
    });

    if (!voidElements[element]) {
        elementString += `</${element}>`;
    }

    return elementString;
};

export const tsxParser = <PropsType>(
    element: string | FunctionComponent<PropsType>,
    properties: PropsType,
    ...children: string[]
) => {
    if (typeof element === 'function') {
        return element(properties);
    }

    return parseNode(element, properties, children);
};

export default tsxParser;
