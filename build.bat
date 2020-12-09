if not exist _release mkdir _release
cd _release

if exist current rmdir current /s /q
mkdir current
cd current

git clone https://github.com/romualdk/refcard-backend.git .

git rev-list --count HEAD > version.txt
set /P version=<version.txt

set prefix=refcard-backend-v
set tag=%prefix%%version%

cd ..
if exist %tag% rmdir %tag% /s /q
rename current %tag%
cd %tag%

call composer install --no-dev --prefer-dist --optimize-autoloader

cd ..
tar -a -c -f %tag%.zip %tag%

echo %tag%