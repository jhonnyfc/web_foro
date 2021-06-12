#!/bin/bash

BOLDRED="\e[1;31m"
BOLDBLUE="\e[1;36m"
ENDCOLOR="\e[0m"





run_php_cs_fixer()
{

	test -x "vendor/bin/php-cs-fixer2"

	if [ $? -ne 0 ]; then
		echo -e "${BOLDRED}[+] Php CS Fixer is not installed.${ENDCOLOR}"
		return 1;
	fi

	echo -e "${BOLDBLUE}[+] Running Php CS Fixer...${ENDCOLOR}"

	for FILE in $1
	do
		vendor/bin/php-cs-fixer fix $FILE
	done

}

# cd to the root of the git repository
cd $(git rev-parse --show-toplevel)

FILES=$(git diff --cached --name-only --diff-filter=ACM | grep ".*\.php$")

# Php Lint
echo -e "${BOLDBLUE}[+] Running php lint...${ENDCOLOR}"

for FILE in $FILES
do
	php -l $FILE	
done

# Php Code Sniffer
echo -e "${BOLDBLUE}[+] Running Php Code Sniffer...${ENDCOLOR}"

test -x "vendor/bin/phpcs"

if [ $? -ne 0 ]; then
	echo -e "${BOLDRED}[+] Php Code Sniffer is not installed.${ENDCOLOR}"
	exit 1;
fi

for FILE in $FILES
do
	vendor/bin/phpcs -pv --colors --cache --standard=PSR12 --extensions=php $FILE
done

# Php CS Fixer
read -p "Do you wish to run Php CS Fixer?[Y/n]" yn
    
if [[ "$yn" = "Y" || "$yn" = "y" ]]; then
	run_php_cs_fixer "${FILES[@]}"
fi

if [[ $? -ne 0 ]]; then
	exit 1;
fi

# PhpUnit
echo -e "${BOLDBLUE}[+] Running tests...${ENDCOLOR}"

docker exec $(docker ps -qf "name=^laravel-php$") test -x "vendor/bin/phpunit"

if [ $? -ne 0 ]; then
	echo -e "${BOLDRED}[+] PhpUnit is not installed.${ENDCOLOR}"
	exit 1;
fi

docker exec $(docker ps -qf "name=^laravel-php$") "vendor/bin/phpunit"

if [ $? -ne 0 ]; then
	echo -e "${BOLDRED}\tUnit tests failed ! Aborting commit.${ENDCOLOR}" >&2
	exit 1;
