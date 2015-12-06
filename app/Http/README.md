### Northwood API
- Customers
- Employees
- Products  
- Product Groups
- Product Types
- Reservations
- Transactions

#### Base URL: http://52.8.15.238/api/v1


#### Create Customer  
```
POST /customers

:POST BODY PARAMETERS:
first_name
last_name
phone
email
address
city
state
zip
country
card_number
exp_date
```
#### Update Customer

```
PUT /customers/id

:POST BODY PARAMETERS:
first_name
last_name
phone
email
address
city
state
zip
country
card_number
exp_date
```

#### Delete Customer

```
Delete /customers/id
```
