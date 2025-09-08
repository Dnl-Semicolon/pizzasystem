# Symfony\Component\Routing\Exception\RouteNotFoundException - Internal Server Error
Route [payment.receipt] not defined.

PHP 8.4.8
Laravel 12.26.4
127.0.0.1:8000

## Request

GET /billing

## Headers

* **host**: 127.0.0.1:8000
* **connection**: keep-alive
* **cache-control**: max-age=0
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
* **cookie**: XDEBUG_SESSION=YOUR-NAME; XSRF-TOKEN=eyJpdiI6ImpkWWpRMlZMZzB2eUxFakRQMHptbVE9PSIsInZhbHVlIjoiS29zdkJkcTRxdzFsR2E5WGlCT3VQSVJzNlVwb1cxSWxaM2dkdStmdmZDWld5T0w0SVZOMStYNWdrZ2I3a3pjbk43enRPL3hWOXFkdGYxK2I4YUE3T0RTV05FSno4WVpGOWVRMFlhYzk0ZGF5bzVURWxMbjJDMDZEc00yT3NXNloiLCJtYWMiOiJlYzY1MmRhYjYyOWJjMmMwMDVkMWQzNGY3Y2EwMzcxNTU3N2Q1Zjk2OTA1NTk3NWI5YTM1ZThkZDAxMGFmOWQxIiwidGFnIjoiIn0%3D; pizza_session=eyJpdiI6IjdzVVlNQVJPWW5sVzc1c1Vhajlsamc9PSIsInZhbHVlIjoiWk5ZL2NJOEQ2MXhjenQ1RWVTRWtqZzUxeVFvbUR5TUNJSnUvWW9QTGhJajZrTUJNUUVjMHRhYnhqWUMzbGF4VWtEQVg5SFJEMTFPblE0MFZSa3hOSGhBRGpDV1BERXZLMWptdTA1TmJ3ejN4YTBKVVc5bVphcXIwcHlua1JDLzEiLCJtYWMiOiI2ZWFhMjY5Njc5ODU5YThlY2YzYTU5YjlmYmM4ZDFjNTQzZWUwNTg5OTczZWZhMjc2ZTU1MTI3ZTM2N2EzYWNhIiwidGFnIjoiIn0%3D

## Route Context

controller: App\Http\Controllers\BillingController@index
route name: billing.index
middleware: web, auth

## Route Parameters

No route parameter data available.

## Database Queries

* mysql - select * from `sessions` where `id` = 'xTFhVcGmJbp221mfEd2G4cwcY9Mea8avyCby9NeI' limit 1 (57.57 ms)
* mysql - select * from `users` where `id` = 1 limit 1 (1.63 ms)
* mysql - select count(*) as aggregate from `payments` where `payable_type` = 'order' and exists (select * from `orders` where `payments`.`payable_id` = `orders`.`id` and `user_id` = 1) (5.94 ms)
* mysql - select * from `payments` where `payable_type` = 'order' and exists (select * from `orders` where `payments`.`payable_id` = `orders`.`id` and `user_id` = 1) order by `created_at` desc limit 15 offset 0 (1.61 ms)
* mysql - select * from `orders` where `orders`.`id` in (1, 2, 3) (0.67 ms)
* mysql - select * from `order_items` where `order_items`.`order_id` in (1, 2, 3) (0.87 ms)
* mysql - select * from `products` where `products`.`id` in (1, 2) (0.53 ms)
* mysql - select * from `payments` where `payable_type` = 'order' and exists (select * from `orders` where `payments`.`payable_id` = `orders`.`id` and `user_id` = 1) and `status` = 'captured' (0.45 ms)
