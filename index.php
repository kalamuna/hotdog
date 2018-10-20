<?php

// Dependencies
require_once 'vendor/autoload.php';

// Set up Twig
$loader = new Twig_Loader_Filesystem('templates');
$twig = new Twig_Environment($loader, [
	'debug' => true
]);
$template = $twig->load('html.twig');
$variables = [];

// Check if a file was uploaded.
if (isset($_FILES['image'])) {
	$errors = array();
	$file_name = $_FILES['image']['name'];
	$file_size = $_FILES['image']['size'];
	$file_tmp = $_FILES['image']['tmp_name'];
	$file_type = $_FILES['image']['type'];
	$file_ext = strtolower(end(explode('.',  $_FILES['image']['name'])));
	$extensions = array("jpeg","jpg","png");
	if (in_array($file_ext, $extensions) === false){
		$variables['errors'][] = "extension not allowed, please choose a JPEG or PNG file.";
	}
}

// Render the page
echo $template->render($variables);