<?php

/**
 * @file
 * Fetches the IDs necessary to configure this app.
 * @see config.sample.php
 */
require_once 'source/bootstrap.php';

$results = $service->courses->listCourses();

$courses = $results->getCourses();
if (count($courses) == 0) {
  print "No courses found.\n";
}
else {
  print "Courses:\n";
  foreach ($courses as $course) {
    /** @var Google_Service_Classroom_Course $course */
    print $course->getId() . ': ' . $course->getName() . PHP_EOL;
    $studentResource = $service->courses_students->listCoursesStudents($course->getId());
    $students = $studentResource->getStudents();
    foreach ($students as $student) {
      /** @var Google_Service_Classroom_Student $student */
      $profile = $student->getProfile();
      print '  ' . $student->userId . ': ' . $profile->getName()->getFullName() . PHP_EOL;
    }
  }
}
