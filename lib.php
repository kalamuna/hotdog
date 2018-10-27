<?php

use Google\Cloud\Vision\V1\ImageAnnotatorClient;

/**
 * Process the given filepath to check if it's a hotdog.
 */
function processFile($filepath) {
	$output = [];

	// Retrieve the image information.
	$data = file_get_contents($filepath);
	$output['base64'] = base64_encode($data);
	$output['type'] = pathinfo($filepath, PATHINFO_EXTENSION);

	// Check for if the image contains a hot dog.
	$properties = checkHotDog($filepath);
	if ($properties['ishotdog']) {
		$output['hotdog'] = true;
		$output['title'] = 'Hot Dog';
		$output['description'] = $properties['description'];
	}
	else {
		$output['hotdog'] = false;
		$output['title'] = 'Not a Hot Dog';
		$output['description'] = $properties['description'];
	}

	if (isset($properties['error'])) {
		$output['error'] = $properties['error'];
	}

	return $output;
}

/**
 * Checks whether or not the given image is a hot dog.
 */
function checkHotDog($data) {
	$output = [];

	// Create the Vision API client.
	$imageAnnotator = new ImageAnnotatorClient([
	  'credentials' => ".service_account.json",
	]);

	// Detect objects within the image.
	$response = $imageAnnotator->objectLocalization(fopen($data, 'r'));

	// Retrieve human readable names of each object.
	$objects = $response->getLocalizedObjectAnnotations();

	// Loop through each object, and check whether it's a hot dog.
	$hotdog = false;
	$objectString = '<ul>';
	foreach ($objects as $object) {
		$name = $object->getName();
		$score = $object->getScore();
		$objectString .= '<li>' . $name . ': <em>' . $score * 100 . '%</em></li>';
		if ($name == 'Hot dog' && $score >= 0.5) {
			$hotdog = true;
		}
	}
	$objectString .= '</ul>';

	// Now that we've scanned the object, we can close the Vision API.
	$imageAnnotator->close();

	// Construct the output properties.
	$output['ishotdog'] = $hotdog;
	if ($hotdog) {
		$output['description'] = '<p><strong>Your image is a hot dog.</strong></p>' . $objectString;
	}
	else {
		$output['description'] = '<p><strong>Your image is not a hot dog.</strong></p>' . $objectString;
	}

	return $output;
}
