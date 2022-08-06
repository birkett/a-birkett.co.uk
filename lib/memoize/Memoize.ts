export const memoize = <T>(fn: () => T) => {
    const memoized: any = (): T => {
        if (memoized.cache) {
            return memoized.cache;
        }

        memoized.cache = fn();

        return memoized.cache;
    };

    return memoized;
};
