<?php

require_once 'apps/' . $this->app . '/lib/Functions.php';

$this->require_admin ();

$page->layout = 'admin';
$page->add_style ('/apps/' . $this->app . '/css/admin.css');
$page->title = Appconf::get ($this->app, 'Admin', 'name') . ' - ' . __ ('PHP Serialize');

$form = new Form ('post', $this);

$form->verify = 'apps/' . $this->app . '/forms/admin/serialize.php';

echo $form->handle (function ($form) {
	
	global $tpl;
	
	$phpdata = filter_input (INPUT_POST, 'phpdata');
	if (Stools\sanitize_phpdata ($phpdata)) {
		$result = serialize (eval ('return ' . $phpdata));
	} else {
		$result = '';
	}
	
	echo $tpl->render (
		$this->app . '/admin/serialize',
		array ('phpdata' => $phpdata, 'result' => $result)
	);

	$form->controller->add_notification ( __ ('Data serialized'));
});