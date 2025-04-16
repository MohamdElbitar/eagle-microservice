# Customer Fees API

This API allows fetching `fees` and `markup` for a specific customer based on `customer_id`, `item_id`, and `item_type_id`.

## 📌 Installation & Setup

1. Clone the repository:
   ```sh
   git clone https://github.com/your-repo.git
   cd your-repo
   ```
2. Install dependencies:
   ```sh
   composer install
   ```
3. Configure your `.env` file:
   ```env
   APP_URL=http://yourdomain.com
   API_CUSTOMER_URL=
   ```
4. Run migrations:
   ```sh
   php artisan migrate
   ```
5. Start the development server:
   ```sh
   php artisan serve
   ```

## 📌 API Endpoint

### Get Fees and Markup

**Endpoint:**
```http
GET /api/customers/{customerId}/fees?item_id={item_id}&item_type_id={item_type_id}
```

**Example Request:**
```sh
curl -X GET "http://yourdomain.com/api/customers/1/fees?item_id=1&item_type_id=2"
```

**Example Response:**
```json
{
    "fees": 23,
    "markup": 22
}
```

**Error Responses:**
```json
{
    "message": "Customer not found"
}
```
```json
{
    "message": "Fees not found"
}
```


## 📌 API Route

Add the following to `routes/api.php`:

```php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CustomerController;

Route::get('/customers/{customerId}/fees', [CustomerController::class, 'getFees']);
```

## Create Airports table to get iata code 

```
$ php artisan db:seed --class=AirportSeeder

```
## 📌 License

This project is licensed under the MIT License.
