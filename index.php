<?php

// Dependencies.
require_once 'vendor/autoload.php';
require_once 'lib.php';

// Set up Twig.
$loader = new Twig_Loader_Filesystem('templates');
$twig = new Twig_Environment($loader, [
	'debug' => true
]);

// Load html.twig as the layout.
$template = $twig->load('html.twig');
$variables = [];

// Check if a file was uploaded.
if (isset($_FILES['image'])) {
	$errors = array();
	$file_name = $_FILES['image']['name'];
	$file_size = $_FILES['image']['size'];
	$file_tmp = $_FILES['image']['tmp_name'];
	$file_type = $_FILES['image']['type'];
	$variables['image'] = processFile($file_tmp);
}

// Render the page.
echo $template->render($variables);