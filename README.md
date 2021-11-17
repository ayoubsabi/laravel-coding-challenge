## About Project

Coding Challenge Software Engineer application by Ayoub SABI

## Project installation steps

- Clone project from this repository
- Run `composer install`
- Config and create the database
- Run `php artisan migrate --seed`
- Run `php artisan serve`

## CLI

- Create category command: `php artisan create:category`
- Detele category command: `php artisan delete:category`
- Create product command: `php artisan create:product`
- Detele product command: `php artisan delete:product`

## Web

- Product list endpoint: *GET: api/products*
    - filter by category example: `http://127.0.0.1:8000/api/products?category_id=1`
    - order by name example: `http://127.0.0.1:8000/api/products?order_by[column]=name&order_by[orientation]=asc`
    - order by price example: `http://127.0.0.1:8000/api/products?order_by[column]=price&order_by[orientation]=desc`
    
## Testing

- To test product creation please run `vendor/bin/phpunit`