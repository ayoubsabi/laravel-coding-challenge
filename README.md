## About Project

Coding Challenge Software Engineer application by Ayoub SABI

## Project installation steps

- Clone project from this repository
- Run `composer install`
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
    - order by name example: `http://127.0.0.1:8000/api/products?order_by[name]=asc`
    - order by price example: `http://127.0.0.1:8000/api/products?order_by[price]=asc`
    - order by name and price example: `http://127.0.0.1:8000/api/products?order_by[name,price]=asc`
    
## Testing

- To test product create creation please run `vendor/bin/phpunit`