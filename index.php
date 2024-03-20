<?php

require_once __DIR__.'/vendor/autoload.php';

session_start();

include_once('config.php');

$client = new Google\Client();
$client->setAuthConfig($client_secret);
$client->addScope(Google\Service\Webmasters::WEBMASTERS_READONLY);

if (isset($_SESSION['access_token']) && $_SESSION['access_token']) {
	try{
		  $client->setAccessToken($_SESSION['access_token']);
		  $webmaster = new Google\Service\Webmasters($client);
		  $query_param = new Google\Service\Webmasters\SearchAnalyticsQueryRequest($client);
		  $query_param->startDate = $startDate;
		  $query_param->endDate = $endDate;
		  $query_param->dimensions= ["PAGE", "COUNTRY"];
		  $response = $webmaster->searchanalytics->query($site_url, $query_param);
		  print_r($response->getRows());
		 }catch(\Exception $err){
		 	echo '<pre>'.$err->getMessage().'</pre>';
		 }
  
} else {
  $redirect_uri = $redirect_url;
  header('Location: ' . filter_var($redirect_uri, FILTER_SANITIZE_URL));
}