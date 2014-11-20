<?php

require_once 'apps/' . $this->app . '/lib/Functions.php';

$this->require_admin ();

$page->layout = 'admin';
$page->add_style ('/apps/' . $this->app . '/css/admin.css');
$page->title = Appconf::get ($this->app, 'Admin', 'name') . ' - ' . __ ('JSON Pretty Print');

$form = new Form ('post', $this);

$form->verify = 'apps/' . $this->app . '/forms/admin/jsonprettyprint.php';

echo $form->handle (function ($form) {
	
	global $tpl;

	$jsondata = filter_input (INPUT_POST, 'jsondata');
	$result = Stools\pretty_json (json_decode ($jsondata));
	
	echo $tpl->render (
		$this->app . '/admin/jsonprettyprint',
		array ('jsondata' => $jsondata, 'result' => $result)
	);

	$form->controller->add_notification ( __ ('JSON pretty printed'));
});