# 🚀 Order Fulfillment System

A Laravel-based solution for managing customer orders with custom pricing and automated workflows.

## ✨ Features
- **Customer Types**: Regular, Wholesale, VIP
- **Dynamic Pricing**: Automatic discounts per customer type
- **Order Workflow**: Draft → Approved → Delivered/Cancelled
- **Immutable Orders**: Lock after completion
- **REST API**: Full CRUD operations
- **Audit Trail**: Complete order history

## 🛠 System Requirements
- PHP 8.1+
- MySQL 5.7+
- Composer 2.0+


## Features
- ✅ Customer categorization (Regular, Wholesale, VIP)
- ✅ Dynamic pricing based on customer type
- ✅ Order status workflow (Draft → Approved → Delivered/Cancelled)
- ✅ Immutable orders after delivery/cancellation
- ✅ RESTful API endpoints
- ✅ Comprehensive validation rules

## System Architecture
```text
app/
├── Controllers/
│   └── OrderController.php
├── Models/
│   ├── Customer.php
│   ├── Order.php
│   ├── Product.php
│   └── OrderItem.php
├── Services/
│   ├── DiscountStrategies/
│   │   ├── RegularCustomerDiscount.php
│   │   ├── WholesaleCustomerDiscount.php
│   │   └── VIPCustomerDiscount.php
│   └── OrderStates/
│       ├── DraftState.php
│       ├── ApprovedState.php
│       ├── DeliveredState.php
│       └── CancelledState.php
config/
database/
routes/
tests/

## API Endpoints

### Order Management

| Method   | Endpoint                     | Description                  |
|----------|------------------------------|------------------------------|
| `GET`    | `/api/orders`                | List all orders              |
| `POST`   | `/api/orders`                | Create new order             |
| `GET`    | `/api/orders/{id}`           | Get order details            |
| `PUT`    | `/api/orders/{id}`           | Update order                 |
| `DELETE` | `/api/orders/{id}`           | Delete order                 |
| `POST`   | `/api/orders/{id}/status`    | Change order status          |



## 🚦 Installation

```bash
# Clone repo
git clone https://github.com/yourusername/order-fulfillment-system.git
cd order-fulfillment-system

# Install dependencies
composer install

# Setup environment
cp .env.example .env
php artisan key:generate

# Configure database (edit .env)
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=order_fulfillment
DB_USERNAME=root
DB_PASSWORD=

# Run migrations
php artisan migrate --seed

# Start server
php artisan serve
