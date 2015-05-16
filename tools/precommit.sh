#!/bin/sh

outstyle='compressed'
includes='../css/scss'

sassc -I ${includes} -t ${outstyle} ../css/scss/main.scss ../css/main.css
sassc -I ${includes} -t ${outstyle} ../css/scss/christmas.scss ../css/christmas.css
