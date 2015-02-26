#!/bin/sh

echo "Generating report..."
phpmd.phar ../ html cleancode,codesize,controversial,design,naming,unusedcode --reportfile phpmd.html
