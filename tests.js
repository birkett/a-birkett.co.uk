const fs = require('fs');
const { test } = require('./lib/test/testSystem');

test(fs.realpathSync('test'));
