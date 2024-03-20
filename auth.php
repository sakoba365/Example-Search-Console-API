<?php

require_once 'vendor/autoload.php';

session_start();

include_once('config.php');


$client = new Google\Client();
$client->setAuthConfig($client_secret);
$client->addScope(Google\Service\Webmasters::WEBMASTERS_READONLY);

$client->setRedirectUri($redirect_url);
$client->setAccessType('offline');
$client->setState($sample_passthrough_value);
$client->setPrompt('consent');
$client->setIncludeGrantedScopes(true);


if (! isset($_GET['code'])) {
	$auth_url = $client->createAuthUrl();
	header('Location: ' . filter_var($auth_url, FILTER_SANITIZE_URL));
} else {
  $client->authenticate($_GET['code']);
  $_SESSION['access_token'] = $client->getAccessToken();
  $home_uri = $script_path;
  header('Location: ' . filter_var($home_uri, FILTER_SANITIZE_URL));
}