export class ElementArray<T> extends Array<T> {
    public constructor() {
        super();
    }

    public toString(): string {
        return this.join('');
    }
}
