<?Php
$title = 'OhYesChat Admin';
$params = array(
	'title' => $title,
	'content' =>  elgg_view('ohyes/chat/admin/dashboard'),
);

$body = elgg_view_layout(NULL, $params);

echo elgg_view_page($title, $body, 'ohyeschat');
