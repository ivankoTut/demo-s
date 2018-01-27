link.test
=========

A Symfony project created on January 23, 2018, 8:33 pm.


#install app
```
git clone git@github.com:ivankoTut/demo-s.git
cd demo-s
composer install
cp app/config/parameters.yml.dist app/config/parameters.yml // add database
php bin/console doctrine:database:create
php bin/console doctrine:migrations:migrate
php bin/console doctrine:fixtures:load // add demo data (optional)
yarn install
npm prod
```