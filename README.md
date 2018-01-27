link.test
=========

A Symfony project created on January 23, 2018, 8:33 pm.


#install app
```
git clone git@github.com:ivankoTut/demo-s.git
cd demo-s
composer install
php bin/console doctrine:database:create
php bin/console doctrine:migrations:migrate
php bin/console doctrine:fixtures:load // add demo data (optional)
yarn install
npm prod
```

##Add to cron this command
```
php bin/console app:drop-old-link
```

##api to create a short link
```
post api/link
params
{
    full_link: 'value',
    short_link: 'value' //optional
}
```