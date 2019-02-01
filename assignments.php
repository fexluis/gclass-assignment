<?php

/**
 * @file
 * Creates assignments upstream based upon the 'students' array in $conf.
 * @see config.sample.php
 */
require_once 'source/bootstrap.php';

$assignments = [];

// Get the starting date.
$start_date = strtotime("next monday");
print "Start date: [" . date('Y-m-d', $start_date) . "]: ";
$input = trim(fgets(STDIN));
if ($input && ($changed_date = strtotime($input))) {
  $start_date = $changed_date;
  print "Using " . date('Y-m-d', $start_date) . PHP_EOL;
}

// Collect all of the assignments as specified by configuration.
foreach ($conf['students'] as $student_name => $student_info) {
  $students = !empty($student_info['id']) ? [$student_info['id']] : NULL;
  print "$student_name:\n";
  foreach ($student_info['subjects'] as $subject_name => $subject_info) {
    foreach ($subject_info['days'] as $day) {
      print "  Day $day: $subject_name: $subject_info[title]: ";
      $title = trim(fgets(STDIN));
      $day_to_use = $start_date + ($day * 86400);

      if (!$title) {
        // Skip assignment if not set to use default
        if (empty($subject_info['use default'])) {
          continue;
        }
        $title = "$subject_name: $subject_info[title]";
      }
      else {
        $title = "$subject_name: $subject_info[title]: $title";
      }
      $assignments[] = [
        $conf['course_id'],
        $title,
        ['year' => date('Y', $day_to_use), 'month' => date('m', $day_to_use), 'day' => date('d', $day_to_use)],
        $students
      ];
    }
  }
}

// Print back the assignments and confirm.
print "The following assignments will be created:\n";
foreach ($assignments as $data) {
  print '  ' . $data[1] . ' ' . $data[2]['year'] . '-' . $data[2]['month'] . '-' . $data[2]['day'] . PHP_EOL;
}

$confirm = FALSE;
while (!$confirm || strtolower($confirm[0]) != 'y') {
  print "Create these assignments? ";
  $confirm = trim(fgets(STDIN));
  if ($confirm && strtolower($confirm[0]) == 'n') {
    print "Aborting\n";
    exit;
  }
}

print "Creating assignments.\n";
// Create the assignments upstream.
foreach ($assignments as $data) {
  $assignment = call_user_func_array('create_assignment', $data);
  if ($assignment) {
    print "Created assignment " . $assignment->title . PHP_EOL;
  }
}

