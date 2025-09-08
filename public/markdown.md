# Illuminate\Database\QueryException - Internal Server Error
SQLSTATE[42S22]: Column not found: 1054 Unknown column 'payable_type' in 'where clause' (Connection: mysql, SQL: select * from `orders` where `payable_type` = order and `orders`.`id` in (1, 2, 3))

PHP 8.4.8
Laravel 12.26.4
127.0.0.1:8000

## Request

GET /billing

## Headers

* **host**: 127.0.0.1:8000
* **connection**: keep-alive
* **sec-ch-ua**: "Chromium";v="140", "Not=A?Brand";v="24", "Google Chrome";v="140"
* **sec-ch-ua-mobile**: ?0
* **sec-ch-ua-platform**: "macOS"
* **upgrade-insecure-requests**: 1
* **user-agent**: Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Safari/537.36
* **accept**: text/html,application/xhtml+xml,application/xml;q=0.9,image/avif,image/webp,image/apng,*/*;q=0.8,application/signed-exchange;v=b3;q=0.7
* **sec-fetch-site**: same-origin
* **sec-fetch-mode**: navigate
* **sec-fetch-user**: ?1
* **sec-fetch-dest**: document
* **referer**: http://127.0.0.1:8000/profile?tab=billing
* **accept-encoding**: gzip, deflate, br, zstd
* **accept-language**: en-US,en;q=0.9,zh-CN;q=0.8,zh;q=0.7
* **cookie**: XDEBUG_SESSION=YOUR-NAME; XSRF-TOKEN=eyJpdiI6IktKeHIxV0VMNUZodzA3TWxJdW91N0E9PSIsInZhbHVlIjoiMVMyUWdlTzhOeG1wbTcyck5VcE5sV2Y3RVFWRmtlZWJ0RUFqRTNvWGtQM0x1TUI5UFZ2VS9kZUkyVTlNa01NNzMyS1dQVmphaTgvZjIyeThYY0RvTElDMHJpV0FERE1EQ1FUTVRYcTZvRzVDcWpVQXVXTTNGZ1UrUlRTQmlWYzMiLCJtYWMiOiJjZDk4ZmE0ZGE4ZDUxNjFhZDRlNmQ5MGZmNzA2N2U4OGNlNDQ2ZTMyMTEyY2ZhZDUwZWMwMjBmNWQ4MGQzZDlmIiwidGFnIjoiIn0%3D; pizza_session=eyJpdiI6InVMQ1gwS20yV2VWN3BSbDRRSmdHeVE9PSIsInZhbHVlIjoidCtJZEZjVFhzcDlWZ2xqcS9nK2laYWIwUjl6dFdzdzU0cEF5elJDLzJGWUhvWkpRVlJPbDFEWGZtc2NLQUVNVWdKcm1RMTEwdEZYUnJnYy9FTGUyWFovL1E0Q1F0VUpNREJ6d3NNdXFoUVo1QUc4UmhlRHZwdGFzemVjT1Z0QlIiLCJtYWMiOiJjM2IzZjBlNjczNmFlOGVmODk4ZjA4NGMyODJiYTcyMzgwNzhkZTI2MGM2ZDMzOTQxYjA3N2Q4Yjk4NDliYzU1IiwidGFnIjoiIn0%3D

## Route Context

controller: App\Http\Controllers\BillingController@index
route name: billing.index
middleware: web, auth

## Route Parameters

No route parameter data available.

## Database Queries

* mysql - select * from `sessions` where `id` = 'xTFhVcGmJbp221mfEd2G4cwcY9Mea8avyCby9NeI' limit 1 (6.83 ms)
* mysql - select * from `users` where `id` = 1 limit 1 (2.49 ms)
* mysql - select count(*) as aggregate from `payments` where exists (select * from `orders` where `payments`.`payable_id` = `orders`.`id` and `user_id` = 1 and `payable_type` = 'order') (2.65 ms)
* mysql - select * from `payments` where exists (select * from `orders` where `payments`.`payable_id` = `orders`.`id` and `user_id` = 1 and `payable_type` = 'order') order by `created_at` desc limit 15 offset 0 (5.04 ms)
