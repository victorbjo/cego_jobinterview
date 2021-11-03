# cego_jobinterview
Repo of my solution to the assignment put forward by cego for recruitment.
https://github.com/cego/interview-assignment
Entire solution is developed in PHP using MySQL



Requirements:
- PHP installed (Only tested on version 8.0.12)
- Mysqli enabled (This can be checked in php.ini in your php folder)
- A MySQL server up and running (Tested with XAMPP)
- Make sure your php.exe is in your PATH
- Either make sure the credential to the MySQL server is host="localhost", user="root" password="".
	If this is not the case, please change the credentials in DbFunctions.php at line 4, and in retrieveData.php at line 11

How to run program:
- php retrieveData "Custom SQL Query"
Example: opath\cego_jobinterview> php retrieveData.php "SELECT firstname, lastname FROM users WHERE email LIKE '%org%'"


OBS - Since all path variables in the program is variable, you will have to be in the cego_jobinterview folder when running the command
OBS - Make sure to put '"' around SQL query, and "'" around conditions such as %org%


The output of the program:
Every step along the way will output whether or not it was successful.
If a crucial step is not succesful, the program will output the error, and then terminate.
If all steps are successful, the program will use the custom query to retrieve data and save it to "sqlQuery.csv" in the same folder.
After saving the data it will delete all the ROWS from which data has been retrieved.
"Deleting" a single cell could also be done, by substituting the DELETE with UPDATE and then update the affected cells to be blank.



Test:
- Writing error: (To run test "C:\path\cego_jobinterview> php tests.php")
	The writing error test will run the program as usual, but before validating the file it will add a single "." to the end of the files data.
	The program should then fail the validation step and then not delete the data

Considerations:
- Known errors:
	If "sqlQuery.csv" is already open, it will not be able to save the data and delete the retrieved data.
	If a table "users" already exists it will not be able to create a new one. Neither will it update the current "users" table. 
		However it will continue running even it if fails at this step
	
- Next steps:?
	Set up protection against SQLI attacks.
	Should be able to try again if it encounters an error in any of the steps, at the moment it just exits every time.
	Should be able to delete current table users if it already exists.
	More tests should be made. At the moment only writing error test is made.
- Security concerns:
	No protection at the moment against SQLI attacks, making it possible to delete the entire database without saving the data first




Additional notes:
- Only tested on Windows 10 Pro 64 bit
- Only tested with the given sqldump, but should work with larger and more complex dumps
- Only tested on cmd on Windows