@echo off
REM Batch file to add, commit (with user input), and push changes to git

REM Change to the script's directory (optional, remove if not needed)
REM cd /d %~dp0

git add .

set /p COMMENT="Enter commit message: "

git commit -m "%COMMENT%"
git push origin master
