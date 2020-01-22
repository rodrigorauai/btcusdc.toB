## API BtcUsdc

Solução para conversão de BTC para USDCoin, utilizando api do Coinbase como referência

## Operação cron no servidor

Entrar no arquivo de cron: crontab -e
Para rodar os commands, é necessário adicionar ao arquivo: * * * * * /usr/bin/php-7.2 /var/www/html/btcusdc.to/artisan schedule:run >> /dev/null 2>&1

## API Auth

* Is necessary to login to use the API functions
### Register User
```
POST /api/register
```
Register User 

**Parameters:**

Name | Type
------------ | ------------
name | STRING 
email | STRING 
password | STRING


**Response:**
```javascript
{
    "success": true,
    "token": "eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJodHRwOlwvXC9sb2NhbGhvc3Q6ODAwMFwvYXBpXC9yZWdpc3RlciIsImlhdCI6MTU3OTcxOTQzNywiZXhwIjoxNTc5NzIzMDM3LCJuYmYiOjE1Nzk3MTk0MzcsImp0aSI6IlNMUG1CU2NhWkU4T2xTUzQiLCJzdWIiOjIsInBydiI6Ijg3ZTBhZjFlZjlmZDE1ODEyZmRlYzk3MTUzYTE0ZTBiMDQ3NTQ2YWEifQ.XamMHvOZBxXT_XizaTmAGBA_tcTK9LD6HqU5rDS87lI",
    "data": {
        "name": "Testea",
        "email": "testeaa@example.com",
        "updated_at": "2020-01-22 18:57:17",
        "created_at": "2020-01-22 18:57:17",
        "id": 2
    }
}
```

### Login User
```
POST /api/login
```
Login User 

**Parameters:**

Name | Type
------------ | ------------
email | STRING 
password | STRING


**Response:**
```javascript
{
    "success": true,
    "token": "eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJodHRwOlwvXC9sb2NhbGhvc3Q6ODAwMFwvYXBpXC9sb2dpbiIsImlhdCI6MTU3OTcxOTUwOCwiZXhwIjoxNTc5NzIzMTA4LCJuYmYiOjE1Nzk3MTk1MDgsImp0aSI6IkEzbXBSNFVvUklEZE5vd2QiLCJzdWIiOjEsInBydiI6Ijg3ZTBhZjFlZjlmZDE1ODEyZmRlYzk3MTUzYTE0ZTBiMDQ3NTQ2YWEifQ.l6Vs0sT0JP5C2OuLzw2auFY7VuucaoNKKu9O8e_GMXk"
}
```
