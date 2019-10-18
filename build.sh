#!/bin/bash

php -d phar.readonly=off phar-composer.phar build .
mv exif2geojson.phar bin/
