<?php

$this->require_admin ();

$page->layout = 'admin';
$page->add_style ('/apps/' . $this->app . '/css/admin.css');
$page->title = Appconf::get ($this->app, 'Admin', 'name') . ' - ' . __ ('Control Panel');

echo $tpl->render (
	$this->app . '/admin',
	array ('version' => Appconf::get ($this->app, 'Admin', 'version'))
);