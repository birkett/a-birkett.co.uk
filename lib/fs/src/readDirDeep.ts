import * as fs from 'fs';
import * as path from 'path';

const readDirSyncDeep = (directory: string): string[] => {
    let fileList: string[] = [];

    const files = fs.readdirSync(directory);

    files.forEach((file) => {
        const p = path.join(directory, file);
        const stats = fs.statSync(p);

        if (stats.isDirectory()) {
            fileList = [...fileList, ...readDirSyncDeep(p)];

            return;
        }

        fileList.push(p);
    });

    return fileList;
};

export default readDirSyncDeep;
