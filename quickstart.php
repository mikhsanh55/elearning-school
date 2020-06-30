<?php

require __DIR__ . '/vendor/autoload.php';

if (php_sapi_name() != 'cli') {
    throw new Exception('This application must be run on the command line.');
}


function getClient()
		{
			$client = new Google_Client();
			$client->setApplicationName('Google Calendar API PHP Quickstart');
			$client->setScopes(Google_Service_Calendar::CALENDAR);
			$client->setAuthConfig(__DIR__ . '/credentials.json');
			$client->setAccessType('offline');
			$client->setPrompt('select_account consent');
		
			$tokenPath = 'token.json';
			if (file_exists($tokenPath)) {
				$accessToken = json_decode(file_get_contents($tokenPath), true);
				$client->setAccessToken($accessToken);
			}
			if ($client->isAccessTokenExpired()) {
				if ($client->getRefreshToken()) {
					$client->fetchAccessTokenWithRefreshToken($client->getRefreshToken());
				} else {
					$authUrl = $client->createAuthUrl();
					printf("Open the following link in your browser:\n%s\n", $authUrl);
					print 'Enter verification code: ';
					$authCode = trim(fgets(STDIN));
		
					$accessToken = $client->fetchAccessTokenWithAuthCode($authCode);
					$client->setAccessToken($accessToken);
		
					if (array_key_exists('error', $accessToken)) {
						throw new Exception(join(', ', $accessToken));
					}
				}
				if (!file_exists(dirname($tokenPath))) {
					mkdir(dirname($tokenPath), 0700, true);
				}
				file_put_contents($tokenPath, json_encode($client->getAccessToken()));
			}
			return $client;
		}

$client = getClient();
$service = new Google_Service_Calendar($client);
// Refer to the PHP quickstart on how to setup the environment:
// https://developers.google.com/calendar/quickstart/php
// Change the scope to Google_Service_Calendar::CALENDAR and delete any stored
// credentials.

$event = new Google_Service_Calendar_Event(array(
	'summary' => 'Google I/O 2015',
	'location' => '800 Howard St., San Francisco, CA 94103',
	'description' => 'A chance to hear more about Google\'s developer products.',
	'start' => array(
	  'dateTime' => '2015-05-28T09:00:00-07:00',
	  'timeZone' => 'America/Los_Angeles',
	),
	'end' => array(
	  'dateTime' => '2015-05-28T17:00:00-07:00',
	  'timeZone' => 'America/Los_Angeles',
	),
	'recurrence' => array(
	  'RRULE:FREQ=DAILY;COUNT=2'
	),
	'attendees' => array(
	  array('email' => 'lpage@example.com'),
	  array('email' => 'sbrin@example.com'),
	),
	'reminders' => array(
	  'useDefault' => FALSE,
	  'overrides' => array(
		array('method' => 'email', 'minutes' => 24 * 60),
		array('method' => 'popup', 'minutes' => 10),
	  ),
	),
  ));
  
  $calendarId = 'primary';
  $event = $service->events->insert($calendarId, $event);
  printf('Event created: %s\n', $event->htmlLink);
  

?>