<?php

if (count($argv) === 1) {
	fwrite(STDERR, "\n\e[1;37mexif2geojson\e[0m by LGND (https://lgnd.com)\n\n");
  fwrite(STDERR, "\e[1;33mUsage:\e[0m php " . basename($_SERVER['PHP_SELF']) . " [*.jpg] > output.geojson\n\n");
	exit();
}

require __DIR__.'/vendor/autoload.php';

$geojson = [
	'type' => 'FeatureCollection',
	'features' => []
];
$reader = \PHPExif\Reader\Reader::factory(\PHPExif\Reader\Reader::TYPE_NATIVE);

$processedCount = 0;
foreach (array_slice($argv, 1) as $file) {
	$data = $reader->read($file);
	if ($data === false) {
		fwrite(STDERR, "\e[1;33mWARNING:\e[0m invalid JPEG {$file}\n");
		continue;
	}

	$exif = $data->getData();
	if (!isset($exif['gps'])) {
		fwrite(STDERR, "\e[1;33mWARNING:\e[0m No GPS EXIF data in {$file}\n");
		continue;
	}

	// If we've made it to here, we've got a JPEG with GPS coords
	$processedCount++;

	list($lat,$lon) = explode(',', $exif['gps']);

	$geojson['features'][] = [
		'type' => 'Feature',
		'geometry' => [
			'type' => 'Point',
			'coordinates' => [(float)$lon,(float)$lat]
		],
		'properties' => array_merge(['name' => str_replace(__DIR__,'',$file)], $exif),
	];
}
echo json_encode($geojson);

fwrite(STDERR, "\n\e[1;32mProcessed {$processedCount} files\e[0m\n");

__HALT_COMPILER();
