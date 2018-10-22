<?php

/*use Google\Cloud\Vision\VisionClient;
*/

use Google\Cloud\Vision\V1\ImageAnnotatorClient;


function processFile($filepath) {
	$output = [];

	// Retrieve the image information.
	$data = file_get_contents($filepath);
	$output['base64'] = base64_encode($data);
	$output['type'] = pathinfo($filepath, PATHINFO_EXTENSION);


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


function checkHotDog($data) {
	$output = [];


	$imageAnnotator = new ImageAnnotatorClient([
      'credentials' => ".service_account.json",
    ]);


    $response = $imageAnnotator->objectLocalization(fopen($data, 'r'));
    $objects = $response->getLocalizedObjectAnnotations();

    $hotdog = false;
    $objectString = '<ul>';
    foreach ($objects as $object) {
    	$name = $object->getName();
    	$score = $object->getScore();
    	$objectString .= '<li>' . $name . ': ' . $score * 100 . '%</li>';
        if ($name == 'Hot dog' && $score >= 0.5) {
        	$hotdog = true;
        }
    }
    $objectString .= '</ul>';
    $imageAnnotator->close();
    $output['ishotdog'] = $hotdog;

    if ($hotdog) {
    	$output['description'] = '<p>Your image is a hot dog.</p>' . $objectString;
    }
    else {
    	$output['description'] = '<p>Your image is not a hot dog.</p>' . $objectString;
    }

	return $output;
}
