composer require make
composer require annotations
composer require dump
composer require server
composer require template
composer require orm
composer require profiler

//command
php bin/console doctrine:schema:update --force
php bin/console make:entity --regenerate 