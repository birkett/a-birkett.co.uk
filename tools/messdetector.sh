#!/bin/sh

echo "Generating report..."
phpmd ../public/ html cleancode,codesize,controversial,design,naming,unusedcode --reportfile phpmd-public.html
phpmd ../private/ html cleancode,codesize,controversial,design,naming,unusedcode --reportfile phpmd-private.html
