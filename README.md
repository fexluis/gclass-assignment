# Classroom Assignment Creator
This small utility uses the Google classroom API to quickly create assignments based upon a configuration

## Background
I homeschool my two children, and we use Google Classroom as a way to track their assignments across different systems. For example, the math program they use has pages to read or exercises to do daily. For science we do activities 2-3 days a week. We have regular semi-structured "Do something artistic" time a couple of days a week.

This is great for the kids, as they can easily see what needs to be done and they can work on much of their material without direct guidance, coming to us when they need help. However, the classroom UX for creating the assignments is quite awkward, and tended to be error prone as I would forget to assign 1 out of 5 math assignments to just one student, or would assign it to the wrong student, or I would select the wrong day. When I found the classroom API, I realized I could simplify my administrative burden while still giving my kids the structure that they seem to thrive in.

## Requirements
* PHP 5.6 or newer, plus a basic knowledge of PHP.
* Teacher/administrator access on at least one google classroom
* A shell environment that can run PHP commands. Currently this is tested only on CentOS linux running PHP 5.6.
* A basic knowledge of PHP is probably necessary to make use of this, particularly to set up the configuration array.
* Recommend using an IDE or editor that can provide code highlighting and visual cues for code correctness, such as PHPStorm (not free), Eclipse (free), or EditPlus. There are others too.

## Caveats
Google's classroom API does not support topics, so all assignments get created without a topic. I can't find a way around this at this time. For my purposes we decided to stop using topics, as the kids don't pay attention to them anyway.

I only need to support a single course, so at the moment my assignment creator only handles that.
## Setup
### Quickstart
Go through the PHP Quickstart for classroom API here: https://developers.google.com/classroom/quickstart/php
 * Enable the API
 * Use composer to create the vendor directory. This should be a sibling of the source directory.
 * cut and paste the credentials.json into `data/credentials.json`

### Fetch IDs
* Copy config.sample.php to config.php in the source directory.
* `php getids.php`
* Note the course ID and the IDs of the students, you will need these to set up the assignment base.

### Configure courses and student signups
`$conf['students']` contains a nested array. 

The first key in the array should be `'course_id'` and it should be set to the course ID identified by `getids.php` above.

The other keys of the top level array are the name or names of the student(s) (which will be printed as feedback, so capitalize appropriately). This can actually be multiple students, as shown in the example.
 
 The student data array contains one key and one optional key. The optional `id` array can be left out if providing data to the entire class. Otherwise, provide either a single id or an array of IDs if using multiple students.
 
 The `subjects` array contains a list of subjects by name, such as Math or Science. The subject will be prefixed to the title of the assignment. Each entry in the subjects array represents an individual assignment with the following keys:
 * `title`: The basic title of the assignment. This will be extended by user input.
 * `days`: A 0 based array of which days to use. `[0, 1, 2, 3, 4]` will create the assignment for all 5 days of the week. `[0, 2, 4]` will create the assignment Monday, Wednesday and Friday. `[1, 3]` will create the assignment Tuesday and Thursday.
 * `use default`: By default, if the user presses enter and puts in no data for an assignment, it will be skipped. That way if you vary how much of one particular subject you use in a week, simply enter the days you want. However, if you don't want to have to enter anything and will always have a simple assignment on the given days, add `'use default' => TRUE` to the array, and pressing enter will use the assignment anyway. For example, "Art time" doesn't need description.
 * See config.sample.json to see how this works in practice.
 
### Configure additional ad hoc groups
By adding any arbitrary key to $conf, you can create additional groupings that can be created. This is useful for irregular assigments that can be created in addition to the primary group but either less often or on a temporary basis.

## Creating assignments

Run `php assignments.php`. If you do not specify an argument, it will use the default `students` group. If you add an argument, it will read `$conf[$argument]` to run the group. For example, `php assignments.php gymnastics` will attempt to create the assignments for `$conf['gymnastics']`. 

It will default the date to the soonest Monday, but you can manually change the date here if you want to work further in advance. Here is sample output from my personal config. Note it's hard to see the user input, in this format, but where you see page numbers, that was directly typed input. The rest was created from configuration.

```
[merlin@maelstrom classroom]$ php assigments.php
Start date: [2019-02-04]:
Charlotte:
  Day 0: Math: BA 5B: 87-88
  Day 1: Math: BA 5B: 89-90
  Day 2: Math: BA 5B: 91-93
  Day 3: Math: BA 5B: 94-95
  Day 4: Math: BA 5B: 96-97
  Day 0: Science: RSO Bio 2: Ch 15 Lab 2
  Day 1: Science: RSO Bio 2: Ch 15 SWYK
  Day 4: Science: RSO Bio 2:
Reuben:
  Day 0: Math: BA 3C: 92-93
  Day 1: Math: BA 3C: 94-95
  Day 2: Math: BA 3C: 96-97
  Day 3: Math: BA 3C: 98
  Day 4: Math: BA 3C: 99
  Day 0: Science: RSO E&S: Rock Cycle Summary
  Day 1: Science: RSO E&S:
Shared:
  Day 1: Typing: typing.com 20 minutes:
  Day 4: Typing: typing.com 20 minutes:
  Day 1: Art: 30 minutes:
Math: BA 5B: 87-88 2019-02-04
Math: BA 5B: 89-90 2019-02-05
Math: BA 5B: 91-93 2019-02-06
Math: BA 5B: 94-95 2019-02-07
Math: BA 5B: 96-97 2019-02-08
Science: RSO Bio 2: Ch 15 Lab 2 2019-02-04
Science: RSO Bio 2: Ch 15 SWYK 2019-02-05
Math: BA 3C: 92-93 2019-02-04
Math: BA 3C: 94-95 2019-02-05
Math: BA 3C: 96-97 2019-02-06
Math: BA 3C: 98 2019-02-07
Math: BA 3C: 99 2019-02-08
Science: RSO E&S: Rock Cycle Summary 2019-02-04
Typing: typing.com 20 minutes 2019-02-05
Typing: typing.com 20 minutes 2019-02-08
Art: 30 minutes 2019-02-05
Create these assignments? y

Created assignment Math: BA 5B: 87-88
Created assignment Math: BA 5B: 89-90
Created assignment Math: BA 5B: 91-93
Created assignment Math: BA 5B: 94-95
Created assignment Math: BA 5B: 96-97
Created assignment Science: RSO Bio 2: Ch 15 Lab 2
Created assignment Science: RSO Bio 2: Ch 15 SWYK
Created assignment Math: BA 3C: 92-93
Created assignment Math: BA 3C: 94-95
Created assignment Math: BA 3C: 96-97
Created assignment Math: BA 3C: 98
Created assignment Math: BA 3C: 99
Created assignment Science: RSO E&S: Rock Cycle Summary: Start a Rock Collection
Created assignment Typing: typing.com 20 minutes
Created assignment Typing: typing.com 20 minutes
Created assignment Art: 30 minutes

```

## TODO
 * [ ] The documentation on getting credentials.json needs to be improved. I need to actually go through that whole process a second time to make sure it's correct.
 * [x] Support for multiple classroom classes.
 * [ ] A configurator that can take you through some of these steps with less needing to write the config file.
 * [ ] config.php should be split up and stored in the data directory. Potentially use .json for config instead of a PHP file.