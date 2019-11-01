# Coding Challenge

### Build a set of REST interfaces (no visual interfaces are needed) that allow us to do the following:

 -  Manage a list of products that have prices. 
 -  Enable the administrator to set concrete prices (such as 10EUR) and discounts to prices either by a concrete amount (-1 EUR) or by percentage (-10%). 
 -  Enable the administrator to group products together to form bundles (which is also a product) that have independent prices. 
 - Enable customers to get the list of products and respective prices. 
 - Enable customers to place an order for one or more products, and provide customers with the list of products and the total price. 

## Technology

- **Laravel Lumen 5.8 [(doc)](hhttps://lumen.laravel.com/docs)**
- **Laravel/Passport** (For API Authentications - [doc](https://laravel.com/docs/5.8/passport) )
- **Entrust** (For Role Based Permission - [doc](https://github.com/Zizaco/entrust) )
- **MYSQL 5.6**
- **PHP 7.2.1**

## Installation
1. Clone the repository from here- 
    ```
    git clone https://github.com/sahidhossen/saloodo-products.git
    ```
2. Install PHP packages with composer
    ```
    composer install
    ```
3. Create a database and setup the **.env** file with your database connection.
    ##### Example - 
    ```
    DB_DATABASE=saloodo
    DB_USERNAME=root
    DB_PASSWORD=root
    ```
4. Then run the bellow command for migrate the database and seeds for demo user.
    ```
    php artisan migrate:refresh --seed
    ```
    It will create user and their roles
    ( Database seeds file location: ```project/database/seeds``` )

    ##### For administrator user
    ```
    username: saloodo@mail.com
    password: saloodo111
    ```
    ##### For customer
    --  User: 1
    ```
    username: customer1@mail.com
    password: customer111
    ```
    --  User: 2
    ```
    username: customer2@mail.com
    password: customer111
    ```
5. Run the project with ``php`` command
    ```
    php -S localhost:8000 -t public
    ```
## Laravel Passport 
For API authentication I have use laravel passport which provide a full OAuth2 server implementation for this project.

## Create password grant type
We need to create a password grant client ID and client secret. 
```
php artisan passport:client --password
```
It will generate ``client_id`` and ``client_secret``
#### Example
```
Client ID: 1
Client secret: P3m86HCRXWDQLjHzpldnk1sOze0FElM4l2X8xrpI
```
-------------
API Uses Documentation
==================
***( I have use postman for test all of the API. )***

## User Login


**URL :**  ``http://ocalhost:8000.com/oauth/token`` 

**Method :** ``POST``

With GuzzleHttp
```
$http = new GuzzleHttp\Client;

$response = $http->post('http://ocalhost:8000.com/oauth/token', [
    'form_params' => [
        'grant_type' => 'password',
        'client_id' => '1',
        'client_secret' => 'P3m86HCRXWDQLjHzpldnk1sOze0FElM4l2X8xrpI',
        'username' => 'saloodo@mail.com',
        'password' => 'saloodo111',
        'scope' => '',
    ],
]);

return json_decode((string) $response->getBody(), true);
``` 
### Result
```
{
    "token_type": "Bearer",
    "expires_in": 31622400,
    "access_token": "",
    "refresh_token": ""
}
```
## Show All Products

***URL :*** ```http://localhost:8000/api/v1/products```

***Method :*** ```GET```

### Header 
```
Authorization : Bearer access_token
```
### Result
```
{
    "success": true,
    "data": []
}
```
## Create Product

***URL :*** ```http://localhost:8000/api/v1/product/create ```
***Method :*** ```POST```

### Header 
```
Authorization : Bearer access_token
```
### Body
```
name: iPhone 11 pro
price: 699
description: ""
grouped: true/false
grouped_ids: product_ids
```
### Result
```
{
    "success": true,
    "data": {
        "name": "iPhone 11 pro With Cover",
        "description": "iPhone 11 cover",
        "image_url": null,
        "stock": 1,
        "grouped": "1",
        "price": 699,
        "group_ids": "1,2",
        "discount": null,
        "updated_at": "2019-10-27 08:00:44",
        "created_at": "2019-10-27 08:00:44",
        "id": 1
    },
    "message": "Product create successfull"
}
```
## Update Product

***URL :*** ```http://localhost:8000/api/v1/product/edit ```
***Method :*** ```POST```

### Header 
```
Authorization : Bearer access_token
```
### Body
```
id: 1
name: iPhone 11 pro
price: 699
description: ""
grouped: true/false
grouped_ids: product_ids
```
### Result
```
{
    "success": true,
    "data": {
        "name": "iPhone 11 pro With Cover",
        "description": "iPhone 11 cover",
        "image_url": null,
        "stock": 1,
        "grouped": "1",
        "price": 699,
        "group_ids": "1,2",
        "discount": null,
        "updated_at": "2019-10-27 08:00:44",
        "created_at": "2019-10-27 08:00:44",
        "id": 1
    },
    "message": "Product update successfull"
}
```

## Create Order 

***URL :*** ```http://localhost:8000/api/v1/order/create ```

***Method :*** ```POST```

### Body 
```
{
	"orders": [
		{
			"id": 1,
			"product_id": 2
		}
	]
}
```
### Result
```
{
    "success": true,
    "orders": [],
    "total_price": 100
}
```


### Show user Orders

***URL :*** ```http://localhost:8000/api/v1/orders ```

***Method :*** ```GET```

### Result 
```
{
    "success": true,
    "data": []
}
```