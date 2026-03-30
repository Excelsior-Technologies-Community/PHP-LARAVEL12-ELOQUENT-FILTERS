# 📦 PHP Laravel 12 - Eloquent Filters Project

This project demonstrates how to build **advanced filtering functionality using Laravel 12 Eloquent Query Scopes**.
It includes a **clean dashboard UI built with Tailwind CSS**, allowing users to filter products by category and price range.

---

# 🚀 Features

* Product filtering by **Category**
* Filter by **Minimum Price**
* Filter by **Maximum Price**
* **Reusable Eloquent Query Scope**
* **Add Product Form**
* **Tailwind CSS UI**
* **Server-side Validation**
* **Responsive Design**

---

# 🛠 Tech Stack

| Technology | Description     |
| ---------- | --------------- |
| Framework  | Laravel 12      |
| Language   | PHP 8.2+        |
| Database   | MySQL / SQLite  |
| Frontend   | Blade Templates |
| Styling    | Tailwind CSS    |

---

# 📥 Installation

## 1 Clone Repository

```bash
composer create-project laravel/laravel php-laravel12-eloquent-filters
cd laravel-eloquent-filters
```

---

## 2 Install Dependencies

```bash
composer install
npm install
npm run dev
```

---

## 3 Setup Environment

```bash
cp .env.example .env
php artisan key:generate
```

---

## 4 Configure Database

Edit `.env`

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=eloquent_filters
DB_USERNAME=root
DB_PASSWORD=
```

---

## 5 Run Migration

```bash
php artisan migrate
```

---

## 6 Seed Demo Data

```bash
php artisan db:seed --class=ProductSeeder
```

---

## 7 Run Project

```bash
php artisan serve
```

Open browser:

```
http://127.0.0.1:8000/products
```

---

# 📂 Project Structure

```
app
 ├── Models
 │    └── Product.php
 │
 ├── Http
 │    └── Controllers
 │          └── ProductController.php
 │
database
 ├── migrations
 │    └── create_products_table.php
 │
 └── seeders
      └── ProductSeeder.php

resources
 └── views
      └── products
           └── index.blade.php

routes
 └── web.php
```

---

# 📌 Routes

`routes/web.php`

```php
use App\Http\Controllers\ProductController;

Route::get('/products', [ProductController::class,'index'])->name('products.index');
Route::post('/products', [ProductController::class,'store'])->name('products.store');
```

---

# 📌 Model

`app/Models/Product.php`

```php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
        'name',
        'category',
        'price'
    ];

    public function scopeFilter($query, array $filters)
    {
        $query->when($filters['category'] ?? null, function ($q,$category){
            $q->where('category',$category);
        })
        ->when($filters['min_price'] ?? null, function ($q,$min){
            $q->where('price','>=',$min);
        })
        ->when($filters['max_price'] ?? null, function ($q,$max){
            $q->where('price','<=',$max);
        });
    }
}
```

---

# 📌 Controller

`app/Http/Controllers/ProductController.php`

```php
namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{

    public function index(Request $request)
    {
        $products = Product::filter(
            $request->only(['category','min_price','max_price'])
        )->get();

        return view('products.index',compact('products'));
    }


    public function store(Request $request)
    {
        $request->validate([
            'name'=>'required',
            'category'=>'required',
            'price'=>'required|numeric'
        ]);

        Product::create($request->all());

        return redirect()->back()->with('success','Product Added');
    }
}
```

---

# 📌 Migration

`database/migrations/create_products_table.php`

```php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('category');
            $table->integer('price');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('products');
    }
};
```

---

# 📌 Seeder

`database/seeders/ProductSeeder.php`

```php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;

class ProductSeeder extends Seeder
{

    public function run()
    {
        Product::insert([

            [
                'name'=>'Laptop',
                'category'=>'Electronics',
                'price'=>50000
            ],

            [
                'name'=>'Mobile',
                'category'=>'Electronics',
                'price'=>20000
            ],

            [
                'name'=>'Chair',
                'category'=>'Furniture',
                'price'=>3000
            ],

            [
                'name'=>'Table',
                'category'=>'Furniture',
                'price'=>6000
            ],

        ]);
    }
}
```

---

# 📌 Blade View

`resources/views/products/index.blade.php`

```blade
<!DOCTYPE html>
<html>
<head>

<title>Product Filters</title>

<script src="https://cdn.tailwindcss.com"></script>

</head>

<body class="bg-gray-100 p-10">

<div class="max-w-6xl mx-auto grid grid-cols-3 gap-6">

<div class="bg-white p-6 rounded shadow">

<h2 class="text-xl font-bold mb-4">Add Product</h2>

<form method="POST" action="/products">

@csrf

<input type="text" name="name" placeholder="Product Name"
class="w-full border p-2 mb-3">

<input type="text" name="category" placeholder="Category"
class="w-full border p-2 mb-3">

<input type="number" name="price" placeholder="Price"
class="w-full border p-2 mb-3">

<button class="bg-blue-500 text-white px-4 py-2 rounded">
Add Product
</button>

</form>

</div>


<div class="col-span-2 bg-white p-6 rounded shadow">

<h2 class="text-xl font-bold mb-4">Filter Products</h2>

<form method="GET" action="/products" class="flex gap-3 mb-4">

<input type="text" name="category"
placeholder="Category"
class="border p-2">

<input type="number" name="min_price"
placeholder="Min Price"
class="border p-2">

<input type="number" name="max_price"
placeholder="Max Price"
class="border p-2">

<button class="bg-green-500 text-white px-4 py-2 rounded">
Filter
</button>

</form>

<table class="w-full border">

<tr class="bg-gray-200">
<th class="p-2">Name</th>
<th class="p-2">Category</th>
<th class="p-2">Price</th>
</tr>

@foreach($products as $product)

<tr class="border-t">
<td class="p-2">{{ $product->name }}</td>
<td class="p-2">{{ $product->category }}</td>
<td class="p-2">{{ $product->price }}</td>
</tr>

@endforeach

</table>

</div>

</div>

</body>
</html>
```

---

.

# Output
<img width="966" height="495" alt="image" src="https://github.com/user-attachments/assets/e7e3e85c-8644-4a1b-9ebd-e71b90799f6d" />
<img width="992" height="498" alt="image" src="https://github.com/user-attachments/assets/809b7371-d0fe-4eb2-a3d5-e89814358828" />


