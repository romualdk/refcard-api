
:: Prepare
if not exist _release mkdir _release
cd _release

if exist current rmdir current /s /q
mkdir current
cd current

:: Clone
git clone https://github.com/romualdk/refcard-backend.git .

:: Get version
git rev-list --count HEAD > version.txt
set /P version=<version.txt

set prefix=refcard-backend-v
set tag=%prefix%%version%

:: Rename to version
cd ..
if exist %tag% rmdir %tag% /s /q
rename current %tag%
cd %tag%

:: Install
call composer install --no-dev --prefer-dist --optimize-autoloader

:: TO DO - delete .gitignore files // but leave vendor??

:: Zip
cd ..
tar -a -c -f %tag%.zip %tag%

:: Clean
rmdir %tag% /s /q

:: Done
echo %tag%