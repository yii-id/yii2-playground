Yii 2 Playground
=================

Ini adalah aplikasi Yii2 playgroud. Aplikasi ini berisi demo-demo bagaimana menggunakan fitur dari Yii2.
Repo ini didesain semudah mungkin agar siapapun dapat berkontribusi dalam pengembangan aplikasi ini.
Selebihnya tentang bagaimana cara berkontribusi silakan baca [Cara Kontribusi](docs/cara-kontribusi.md)

DIRECTORY STRUCTURE
-------------------

```
assets/              contains application assets such as JavaScript and CSS
protected
    assets/              contains application assets such as JavaScript and CSS
    command/             contains console command classes
    config/              contains app configurations
    controllers/         contains Web controller classes
    models/              contains app-specific model classes
    runtime/             contains files generated during runtime
    views/               contains view files for the Web application
    web/                 contains the entry script and Web resources
    widgets/             contains app widgets
vendor/                  contains dependent 3rd-party packages
environments/            contains environment-based overrides
```

INSTALLATION
------------

```
$ git clone https://github.com/yii-id/yii2-playground.git playground
$ cd playground
$ composer install --prefer-dist
$ php init
$ php yii migrate
```