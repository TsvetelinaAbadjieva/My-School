# My-School
PHP application for school data management

Project is released in Codeigniter framework using MVC model.
Three different user roles are defined: admin, teacher, parent.
On login is checked the user's role and is evaluated his access and visibility of the modules in the user interface.
Ex. teacher has access only to classes where he is teaching in, and corresponding to his profile. He could see and manage information only for the class for witch he is responsible. No one teacher can delete a student. This operation is allowed only to admin profile - add, delete, update teachers and students, but he has not permission to insert marks, absences etc.
Parent logged in the system has access only to overview info about school, events and to the profile of his own child.
