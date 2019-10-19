exif2geojson [![Build Status](https://travis-ci.org/lgndhq/exif2geojson.svg?branch=master)](https://travis-ci.org/lgndhq/exif2geojson)
====

exif2geojson is a utility from [LGND](https://lgnd.com) to generate a GeoJSON file with point features at the GPS coordinates specified in a JPEG's EXIF data. It allows you to pass in a list of JPEG files, and outputs a single GeoJSON file with a FeatureCollection full of points.

# Usage

`php exif2geojson.phar *.jpg > output.geojson`
