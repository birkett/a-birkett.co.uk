#!/bin/sh

cloc ../public --skip-uniqueness --force-lang=HTML,tpl
cloc ../private --skip-uniqueness --force-lang=HTML,tpl
