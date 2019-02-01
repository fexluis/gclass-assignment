<?php

/**
 * Returns an authorized API client.
 * @return Google_Client the authorized client object
 */
function client_get() {
  global $conf;
  $client = new Google_Client();
  $client->setApplicationName($conf['app_name']);
  $client->setScopes($conf['scopes']);
  $client->setAuthConfig($conf['credentials_path']);
  $client->setAccessType('offline');
  $client->setPrompt('select_account consent');

  // Load previously authorized token from a file, if it exists.
  // The file token.json stores the user's access and refresh tokens, and is
  // created automatically when the authorization flow completes for the first
  // time.
  $tokenPath = $conf['token_path'];
  if (file_exists($tokenPath)) {
    $accessToken = json_decode(file_get_contents($tokenPath), TRUE);
    $client->setAccessToken($accessToken);
  }

  // If there is no previous token or it's expired.
  if ($client->isAccessTokenExpired()) {
    // Refresh the token if possible, else fetch a new one.
    if ($client->getRefreshToken()) {
      $client->fetchAccessTokenWithRefreshToken($client->getRefreshToken());
    }
    else {
      // Request authorization from the user.
      $authUrl = $client->createAuthUrl();
      printf("Open the following link in your browser:\n%s\n", $authUrl);
      print 'Enter verification code: ';
      $authCode = trim(fgets(STDIN));

      // Exchange authorization code for an access token.
      $accessToken = $client->fetchAccessTokenWithAuthCode($authCode);
      $client->setAccessToken($accessToken);

      // Check to see if there was an error.
      if (array_key_exists('error', $accessToken)) {
        throw new Exception(join(', ', $accessToken));
      }
    }
    // Save the token to a file.
    if (!file_exists(dirname($tokenPath))) {
      mkdir(dirname($tokenPath), 0700, TRUE);
    }
    file_put_contents($tokenPath, json_encode($client->getAccessToken()));
  }
  return $client;
}

/**
 * Create an assignment upstream.
 *
 * @param $course_id
 * @param $title
 * @param $dueDate
 * @param array $students
 * @return Google_Service_Classroom_CourseWork
 */
function create_assignment($course_id, $title, $dueDate, $students = []) {
  global $service;
  $data = [
    'title' => $title,
    'workType' => 'ASSIGNMENT',
    'state' => 'PUBLISHED',
    'dueDate' => $dueDate,
    'dueTime' => ['hours' => 23, 'minutes' => 00],
  ];
  if ($students) {
    $data += [
      'assigneeMode' => 'INDIVIDUAL_STUDENTS',
      'individualStudentsOptions' => ['studentIds' => $students],
    ];
  }

  try {
    $assignment = $service->courses_courseWork->create($course_id, new Google_Service_Classroom_CourseWork($data));
    return $assignment;
  }
  catch (Google_Service_Exception $e) {
    print $e->getMessage();
  }
}
