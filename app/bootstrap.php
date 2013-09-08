<?php

use Rain\Tpl;
use SPSE\PSgen;

/**
 * @author Jan Mochnak <janmochnak@icloud.com>
 * @copyright 2013
 */

require __DIR__.'/../vendor/autoload.php';
require __DIR__.'/../libs/Generator.php';

Tpl::configure( array(
	"tpl_dir" => __DIR__.'/templates/',
	"cache_dir" => __DIR__.'/../temp/',
	'auto_escape' => false
));

$app = new \Slim\Slim(array(
	'templates.path' => __DIR__.'/templates'
));

// route config

$app->get('/', function () use ($app) {
	$app->render('default.php', array('id' => 'heyyy'));
});

$app->get('/download/:file', function ($file) use ($app) {
	$res = $app->response();
	if (file_exists(__DIR__.'/../temp/'.$file.'.pdf')) {
		$res['Content-Type'] = 'application/octet-stream';
		$res['Content-Description'] = 'File Transfer';
		$res['Content-Disposition'] = 'attachment; filename="predna_strana.pdf"';
		readfile(__DIR__.'/../temp/'.$file.'.pdf');
		@unlink(__DIR__.'/../temp/'.$file.'.pdf');
	} else {
		$app->notFound();
	}
});

function createGenerator($post) {
	foreach($post as &$value) {
		if (strlen($value) == 0) {
			exit;
		}
		$value = htmlspecialchars($value, ENT_QUOTES);
	}
	$classes = array(
		'I.', 'II.', 'III.', 'IV.'
	);
	$generator = new Generator();
	$generator->setSubject($post['subject'])
		->setYear($post['year_1'].'/'.$post['year_2'])
		->setStudentId($post['student_id'])
		->setClassroom($classes[ $post['class_1'] ].$post['class_2'])
		->setStudentName($post['name']);
	return $generator;
}

$app->post('/generate', function () use ($app) {
	$req = $app->request();
	if ($req->isAjax()) {
		$generator = createGenerator($req->post());
		echo $generator->getPdf(true);
	}
});

$app->post('/thumb', function () use ($app) {
	$req = $app->request();
	if ($req->isAjax()) {
		$generator = createGenerator($req->post());
		echo base64_encode($generator->getImage());
	}
});

$app->run();