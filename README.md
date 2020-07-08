# js-php-postgres-sample
A simple app to show a way how in easy and clean way, to communicate php with postgres using xhr requests.

# the goal
As mentioned, just a simple app, but showing how to integrate some coll stuff such as vanilla JS, symfony, twig, composer, postgresql, xhr requests in clean way.

# what the app does?
1. Creates a web app using PHP that uses the two Postgresql tables “Colors” and “Votes”.

| Color |
| ------ |
| Red |
| Orange |
| Yellow |
| Green |
| Blue |
| Indigo |
| Violet |

| City | Color | Votes |
| ------ | ------ | ------ |
| Anchorage | Blue | 10,000 |
| Anchorage | Yellow | 15,000 |
| Brooklyn | Red | 100,000 |
| Brooklyn | Blue | 250,000 |
| Detroit | Red | 160,000 |
| Selma | Yellow | 15,000 |
| Selma | Violet | 5,000 |

2. The left column should be populated from reading all the entries in the Colors table.
3. The colors should be links, so that when click on it, an XHR request calls populates the Votes.
4. When Clicking on “Total”, uses only pure JavaScript to add up and present the total.

# Requirements to run the app
1. install php environment on your machine
2. install postgresql
3. Open php.ini file located in C:\xampp\php.
4. Uncomment the following lines in php.ini
```sh
extension=php_pdo_pgsql.dll
extension=php_pgsql.dll
```
5. install composer and run "composer install" in main app folder
6. enjoy, cheers :)
