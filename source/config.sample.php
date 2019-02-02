<?php

$conf['scopes'] = [
  Google_Service_Classroom::CLASSROOM_COURSEWORK_STUDENTS,
  Google_Service_Classroom::CLASSROOM_COURSES,
  Google_Service_Classroom::CLASSROOM_ROSTERS,
  Google_Service_Classroom::CLASSROOM_ANNOUNCEMENTS,
];

$conf['credentials_path'] = DATA_DIR . '/credentials.json';
$conf['token_path'] = DATA_DIR . '/token.json';

##############################################################################
## Personalized setting start here. ##
##############################################################################

// What you tell google the name of your app is. Probably doesn't matter much.
$conf['app_name'] = 'My Homeschool App';

##############################################################################
# Sample
#
# The following sample is written to demonstrate a group of 3 students who
# largely have different assignments but do have some shared. It is completely
# contrived to demonstrate ways this system can be used.
##############################################################################

// Define student ids here to make things easier.
// Make sure they are quoted strings, not raw numbers.
$pat      = '12345678901234567890';
$chris    = '12345678901234567891';
$taylor   = '12345678901234567892';

// 'students' is the default array of assignments.
$conf['students'] = [
  // This ID must be replaced with your actual course ID. Make sure this is quoted and a string, not a raw number.
  'course_id' => '1234567890',
  'Pat' => [
    'id' => $pat,
    'subjects' => [
      'Math' => [
        'title' => 'Beast Academy 5B',
        'days' => [0, 1, 2, 3, 4],
      ],
      'Science' => [
        'title' => 'Real Science Odyssey Bio',
        'days' => [0, 1, 4],
      ],
    ],
  ],
  'Chris' => [
    'id' => $chris,
    'subjects' => [
      'Math' => [
        'title' => 'Beast Academy 3C',
        'days' => [0, 1, 2, 3, 4],
      ],
      'Science' => [
        'title' => 'Real Science Odyssey Earth & Space',
        'days' => [0, 1],
      ],
    ],
  ],
  'Taylor' => [
    'id' => $taylor,
    'subjects' => [
      'Math' => [
        'title' => 'Art of Problem Solving Algebra',
        'days' => [0, 1, 2, 3, 4],
      ],
      'Science' => [
        'title' => 'BFSU',
        'days' => [0, 1],
      ],
    ],
  ],
  'Pat and Chris' => [
    'id' => [$pat, $chris],
    'subjects' => [
      'History' => [
        'title' => 'History Odyssey Middle Ages',
        'days' => [0, 2, 4],
      ],
    ],
  ],
  'Whole Class' => [
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

// This is an example of an additional assignment group, useful for adding ad hoc
// or irregular assignments separately.
$conf['gymnastics'] = [
  // This ID must be replaced with your actual course ID. Make sure this is quoted and a string, not a raw number.
  'course_id' => '1234567890',
  'Chris' => [
    'id' => $chris,
    'subjects' => [
      'Gymnastics' => [
        'title' => '20 minutes',
        'days' => [1, 3],
        'use default' => TRUE,
      ],
    ],
  ]
];


