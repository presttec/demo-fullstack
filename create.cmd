@ECHO OFF

REM https://jansenfelipe.com.br/2016/04/01/lumen-laravel-como-documentar-uma-api-rest-com-swagger/
REM https://blog.quickadminpanel.com/laravel-api-documentation-with-openapiswagger/
REM https://github.com/DarkaOnLine/L5-Swagger
REM https://github.com/DarkaOnLine/L5-Swagger/wiki/Installation-&-Configuration
REM https://material.angular.io/guide/getting-started
REM https://github.com/VientoDigital/ReactNativeLaravelLogin
REM https://github.com/VientoDigital/ReactNativeLaravelLogin
REM 
REM composer require zircote/swagger-php

REM call npm install -g @angular/cli
REM call npm install -g @vue/cli
REM call npm install -g create-react-app
REM call npm install -g expo-cli


for /D %%J IN (C:\opt\demo-fullstack\*) DO (
rd /s /q %%J
)

call composer create-project laravel/laravel laravel-api --prefer-dist
call composer create-project laravel/laravel laravel-vue --prefer-dist
call composer create-project laravel/laravel laravel-react --prefer-dist
call composer create-project laravel/laravel laravel-bootstrap --prefer-dist

for /D %%J IN (C:\opt\demo-fullstack\laravel-*) DO (
cd %%J 
call composer require luthfi/simple-crud-generator:^2.0
call composer require laravel/passport

)
cd C:\opt\demo-fullstack\laravel-api
php artisan make:crud-api Autor
php artisan make:crud-api Livro
php artisan make:crud-api Genero
php artisan make:crud-api Editora

cd C:\opt\demo-fullstack\laravel-bootstrap
call composer require laravel/ui
php artisan ui bootstrap --auth
php artisan make:crud Autor
php artisan make:crud Livro
php artisan make:crud Genero
php artisan make:crud Editora

cd C:\opt\demo-fullstack\laravel-vue
call composer require laravel/ui
php artisan ui vue --auth

cd C:\opt\demo-fullstack\laravel-react
call composer require laravel/ui
php artisan ui react --auth



cd \opt\demo-fullstack
REM call ng new frontend-angular
REM cd frontend-angular
REM call ng add @angular/material
REM call vue create frontend-vue

mkdir frontend-react
cd frontend-react
call npm init -y
call npm install --save react
call npm install --save react-dom

cd ..

REM call create-react-app frontend-react2
for /D %%J IN (C:\opt\demo-fullstack\*) DO (
rd /s /q %%J\vendor
)
REM https://github.com/nafiesl/SimpleCrudGenerator
REM https://codecanyon.net/item/scaffolder-a-powerful-laravel-angular-crud-generator/15702362
git init
git add .
git commit -m "first commit"
git branch -M main
git remote add origin git@github.com:presttec/demo-fullstack.git
git push -u origin main
