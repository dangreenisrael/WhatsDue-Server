#WhatsDue REST API Documentation
[Dan's email]:<mailto:dan@tlvwebdevelopment.com>
##Overview

The purpose of this document is to allow third party applications to interface with the WhatsDue server.  This document is highly technical and is written for developers.  If you are a developer building an integration for WhatsDue and have any questions about the contents of this document, please [email Dan][Dan's email].


##Contents


**Formatting**   

**Managing Courses**  
Creating Courses  
Retrieving Courses  
Updating Courses 
Archiving Courses 
Listing Assignments for Courses 

**Managing Assignments**  
Creating Assignments
Retrieving Assignments 
Updating Assignments  
Archiving Assignments

**FAQ**

<a name="formatting"></a>
##Request formatting 

All requests must contain 2 custom headers, `key` and `secret`.  The value of `key` should be the username of that installation, and the `secret` should be the password.

The base URL for all requests should be `http://admin.whatsdueapp.com/api/teachers`.

All request bodies should be formatted as correct JSON, based on the following example:

```json
{
	"assignment":{
  		"assignment_name":"Exercise 1",
 	 	"description":"Do the first exercise"
 	 	"due_date":"2015-02-27 10:00",
  		"course_id":"209"
 	}
}
```

Improper formatting of JSON will result in a 500 error.

<a name="courses"></a>
##Managing Courses
<a name="createcourse"></a>
Both `course_name` and `instructor_name` are limited to `50 characters`

###Creating a Course

To create a course, a `POST` request should be made to `/courses` in the following format:

```json
{
	"course":{
		"course_name":"Grade 10 Math",
   		"instructor_name":"John Smith"
  	}
}
```

In response, you will receive:

```json
{
    "course": {
        "id": 211,
        "course_name": "Grade 11 Math",
        "instructor_name": "John Smith",
         "school_name": "PS 264",
        "admin_id": "dangreen",
        "archived": false,
        "created_at": 1424590837,
        "last_modified": 1424590837
    }
}
```
<a name="retrievecourse"></a>
### Retrieving a Course

To retrieve a course, send a `GET` request to `/courses/{COURSE_ID}`

In response you will receive:

```json
{
    "course": {
        "id": 215,
        "course_name": "Grade 11 English",
        "instructor_name": "John Smith",
        "admin_id": "dangreen",
        "school_name": "IDC Herzliya",
        "archived": false,
        "created_at": 1424592846,
        "last_updated": 1424592877,
        "last_modified": 1424592877
    }
}
```
<a name="updatecourse"></a>
### Updating a Course

To update a course, a `PUT` request should be sent to `/courses/{COURSE_ID}` in the following format:

```json
{
	"course":{
   		"course_name":"Grade 11 English",
   		"instructor_name":"John Smith",
   		"archived":false
 	}
}
```

In response you will receive

```json
{
    "course": {
        "id": 215,
        "course_name": "Grade 11 English",
        "instructor_name": "John Smith",
        "admin_id": "dangreen",
        "school_name": "IDC Herzliya",
        "archived": false,
        "created_at": 1424592846,
        "last_updated": 1424592877,
        "last_modified": 1424592877
    }
}
```
<a name="archivecourse"></a>
### Archiving a Course

To archive a course, you can either set `"archived":false` in an edit request, or send a `DELETE` request to `/courses/{COURSE_ID}` .

Your response will be an empty response body and a 204 status code.

<a name="listcourseassignments"></a>
### Listing assignments for a Course

To receive a list of assignments for a course, you can send a `GET` request to `/courses/{COURSE_ID}/assignments` 

In response you will receive:

```json
[
    {
        "id": 517,
        "course_id": 209,
        "admin_id": "dangreen",
        "assignment_name": "asdf",
        "description": "asdfasdf",
        "due_date": "Fri Mar 20 2015 12:00:00 GMT+0200",
        "archived": false,
        "created_at": 1422973593,
        "last_modified": 1422973593
    },
    {
        "id": 518,
        "course_id": 209,
        "admin_id": "dangreen",
        "assignment_name": "asdf",
        "description": "asdfasdfasdf",
        "due_date": "2015-05-21 10:00",
        "archived": false,
        "created_at": 1422973597,
        "last_updated": 1423042885,
        "last_modified": 1423042885
    }
[
```

<a name="assignments"></a>
##Managing Assignments
<a name="createassignment"></a>
`assignment_name` is limited to `50 characters`  
`description` is limited to `255 characters`

###Creating an Assignment
To create a assignment, a `POST` request should be made to `/assignments` in the following format:



```json
{
	"assignment":{
  		"assignment_name":"First Assignment",
   		"description":"Write Hello World",
   		"due_date":"2015-02-27 10:00",
   		"course_id":"215"
 	}
}
```

In response you will receive:

```json
{
    "assignment": {
        "id": 538,
        "course_id": 215,
        "admin_id": "dangreen",
        "assignment_name": "First Assignment",
        "description": "Write Hello World",
        "due_date": "2015-02-27 10:00",
        "archived": false,
        "created_at": 1424596262,
        "last_modified": 1424596262
    }
}
```

<a name="retrieveassignment"></a>
###Retrieving an Assignment
To retrieve an assignment, send a `GET` request to `/assignments/{ASSIGNMENT_ID}`

In response you will receive:

```json
{
    "assignment": {
        "id": 538,
        "course_id": 215,
        "admin_id": "dangreen",
        "assignment_name": "First Assignment",
        "description": "Write Hello World",
        "due_date": "2015-02-27 10:00",
        "archived": false,
        "created_at": 1424596262,
        "last_modified": 1424596262
    }
}
```

<a name="updateassignment"></a>
### Updating an Assignment

To update an assignment, a `PUT` request should be sent to `/assignments/{ASSIGNMENT_ID}` in the following format:

```json
{
	"assignment":{
   		"assignment_name":"First Assignment",
   		"description":"Write Hello World, twice",
   		"due_date":"2015-02-27 10:00",
   		"archived":false
 	}
}
```

In response, you will receive: 

```json
{
    "assignment": {
        "id": 538,
        "course_id": 215,
        "admin_id": "dangreen",
        "assignment_name": "First Assignment",
        "description": "Write Hello World, twice",
        "due_date": "2015-02-27 10:00",
        "archived": false,
        "created_at": 1424596262,
        "last_updated": 1424597005,
        "last_modified": 1424597005
    }
}
```

<a name="archiveassignment"></a>
### Archiving an Assignment

To archive an assignment, you can either set `"archived":false` in an edit request, or send a `DELETE` request to `/assignments/{ASSIGNMENT_ID}`.

Your response will be an empty response body and a 204 status code.

<a name="faq"></a>
##FAQ
Q. Why am I getting a 500 error?
A. You probably have misformed JSON

Q. How do I get an API Key?  
A. Sign up at http://admin.whatsdueapp.com/register. Your username is the `key` and your password is the `secret`

Q. How do I change my secret?  
A. Use the password reset dialogue at http://admin.whatsdueapp.com/resetting/request

Q. Can I change my username or my school's name?   
A. No

Q. How can I get help with technical stuff?  
A. Email [Dan][Dan's Email]
  


<!--
**[Formatting](#formatting)**   

**[Managing Courses](#courses)**  
[Creating Courses](#createcourse)  
[Retrieving Courses](#retrievecourse)  
[Updating Courses](#updatecourse)  
[Archiving Courses](#archivecourse)   
[Listing Assignments for Courses](#listcourseassignments)  

**[Managing Assignments](#assignments)**  
[Creating Assignments](#createassignment)  
[Retrieving Assignments](#retrieveassignment)  
[Updating Assignments](#updateassignment)  
[Archiving Assignments](#archiveassignment)  

**[FAQ](#faq)**
-->
