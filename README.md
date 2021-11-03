# cego_jobinterview
Repo of my solution to the assignment put forward by CEGO for recruitment.
https://github.com/cego/interview-assignment
Entire solution is developed in PHP using MySQL



Requirements:</br>
- PHP installed (Only tested on version 8.0.12)</br>
- Mysqli enabled (This can be checked in php.ini in your php folder)</br>
- A MySQL server up and running (Tested with XAMPP)</br>
- Make sure your php.exe is in your PATH</br>
- Either make sure the credential to the MySQL server is host="localhost", user="root" password="".</br>
	If this is not the case, please change the credentials in DbFunctions.php at line 4, and in retrieveData.php at line 11</br>

How to run program:</br>
- php retrieveData "Custom SQL Query"</br>
Example: opath\cego_jobinterview> php retrieveData.php "SELECT firstname, lastname FROM users WHERE email LIKE '%org%'"</br>


OBS - Since all path variables in the program is variable, you will have to be in the cego_jobinterview folder when running the command</br>
OBS - Make sure to put double quotation marks(") around entire SQL query, and single quotation marks(') around conditions such as %org%</br>


The output of the program:</br>
Every step along the way will output whether or not it was successful.
If a crucial step is not succesful, the program will output the error, and then terminate.
If all steps are successful, the program will use the custom query to retrieve data and save it to "sqlQuery.csv" in the same folder.
After saving the data it will delete all the ROWS from which data has been retrieved.
"Deleting" a single cell could also be done, by substituting the DELETE with UPDATE and then update the affected cells to be blank.



Test:
- Writing error: (To run test "C:\path\cego_jobinterview> php tests.php")</br>
	The writing error test will run the program as usual, but before validating the file it will add a single "." to the end of the files data.
	The program should then fail the validation step and then not delete the data

Considerations:
- Known errors:</br>
	If "sqlQuery.csv" is already open, it will not be able to save the data, but it will not delete any data.</br>
	If a table "users" already exists it will not be able to create a new one. Neither will it update the current "users" table. </br>
		However it will continue running even it if fails at this step
	
- Next steps:?</br>
	Set up protection against SQLI attacks.</br>
	Should be able to try again if it encounters an error in any of the steps, at the moment it just exits every time.</br>
	Should be able to delete current table users if it already exists.</br>
	More tests should be made. At the moment only writing error test is made.</br>
	Keep a log of all failed attempts, especially if the fail originates from a failed data verification
- Security concerns:</br>
	No protection at the moment against SQLI attacks, making it very vulnerable</br>




Additional notes:</br>
- Only tested on Windows 10 Pro 64 bit</br>
- Only tested with the given sqldump, but should work with larger and more complex dumps</br>
- Only tested on cmd on Windows</br>
