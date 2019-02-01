<?php

$conf['scopes'] = [
  Google_Service_Classroom::CLASSROOM_COURSEWORK_STUDENTS,
  Google_Service_Classroom::CLASSROOM_COURSES,
  Google_Service_Classroom::CLASSROOM_ROSTERS,
  Google_Service_Classroom::CLASSROOM_ANNOUNCEMENTS,
];

$conf['app_name'] = 'My Homeschool App';

$conf['credentials_path'] = DATA_DIR . '/credentials.json';
$conf['token_path'] = DATA_DIR . '/token.json';

$conf['course_id'] = 14902692061; // The real one
$conf['students'] = [
  'Charlotte' => [
    'id' => '103365305463898063479',
    'subjects' => [
      'Math' => [
        'title' => 'BA 5B',
        'days' => [0, 1, 2, 3, 4],
      ],
      'Science' => [
        'title' => 'RSO Bio 2',
        'days' => [0, 1, 4],
      ],
    ],
  ],
  'Reuben' => [
    'id' => '109130233383689384944',
    'subjects' => [
      'Math' => [
        'title' => 'BA 3C',
        'days' => [0, 1, 2, 3, 4],
      ],
      'Science' => [
        'title' => 'RSO E&S',
        'days' => [0, 1],
      ],
    ],
  ],
  'Shared' => [
    'subjects' => [
      'Typing' => [
        'title' => 'typing.com 20 minutes',
        'days' => [1, 4],
        'use default' => TRUE,
      ],
      'Art' => [
        'title' => '30 minutes',
        'days' => [1],
        'use default' => TRUE,
      ]
    ]
  ]
];


