#1779256485
ssh-keygen -t ed25519 -C "gore.goli@gmail.com"
#1779256494
cd www
#1779256559
git clone https://github.com/Gbaka01/symfony_cda
#1779256568
cd symfony_cda
#1779256603
php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');"
#1779256603
php -r "if (hash_file('sha384', 'composer-setup.php') === 'c8b085408188070d5f52bcfe4ecfbee5f727afa458b2573b8eaaf77b3419b0bf2768dc67c86944da1544f06fa544fd47') { echo 'Installer verified'.PHP_EOL; } else { echo 'Installer corrupt'.PHP_EOL; unlink('composer-setup.php'); exit(1); }"
#1779256603
php composer-setup.php
#1779256605
php -r "unlink('composer-setup.php');"
#1779256617
php composer.phar update
#1779256695
php bin/console doctrine:migrations:migrate
#1779256733
php composer.phar require symfony/apache-pack
#1779256790
php composer.phar dump-env prod
#1779256831
APP_ENV=prod APP_DEBUG=0 php bin/console cache:clear
