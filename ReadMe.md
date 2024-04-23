Create new application

laravel new l11-roles-perms

cd l11-roles-perms
rm -Rf node_modules package-lock.json

open this project in PhpStorm
edit package.json

locate the penultimate (one before last) `}` in the file.

Add:

```javascript
,
"overrides"
:
{
    "vite"
:
    {
        "rollup"
    :
        "npm:@rollup/wasm-node"
    }
}
```

This adds a way to circumnavigate a DLL error when using Vite on College
PCs (eg room B223, L2-60 et al).

Execurte

```shell
composer require spatie/laravel-permission
```

Publish the Spatie Permission provider files:

```shell
php artisan vendor:publish --provider="Spatie\Permission\PermissionServiceProvider"
```

Step 5: Create Models & Migrations

Now, let’s look at what we want to create. We already have a User Model in our
application, so we will just create a product model and its migration.

```bash
php artisan make:model Product -ars
```

This creates:

- Model `...\app\Models\Product.php`
- Factory `...\database\factories\ProductFactory.php`
-
Migration `...\database\migrations/2024_04_23_085241_create_products_table.php`
- Seeder `...\database\seeders\ProductSeeder.php`
- Request `...\app\Http\Requests\StoreProductRequest.php`
- Request `...\app\Http\Requests\UpdateProductRequest.php`
- Controller `...\app\Http\Controllers\ProductController.php`
- Policy `...\app\Policies\ProductPolicy.php`

app/Models/Product.php

```php
namespace App\Models;
  
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
  
class Product extends Model
{
    use HasFactory;
  
    protected $fillable = [
        'name', 'detail'
    ];
}
```

Let’s go to our app/Models/User.php

We have to add the HasRoles trait.

```php
use Spatie\Permission\Traits\HasRoles;


class User extends Authenticatable
{
    use HasFactory, Notifiable, HasRoles;

```

Good! Let’s head over to the migrations - in the create_products_table

```php
 Schema::create('products', function (Blueprint $table) {
      $table->id();
      $table->string('name');
      $table->text('detail');
      $table->timestamps();
  });
```

Create Roles and Permissions Seeder

```shell
php artisan make:seeder RoleSeeder
```

Open new RoleSeeder

at the top of the file, and after the current `use` statements, add the lines:

```php
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
```

...and also add before the `public function run`...:

```php
    private $permissions = [
        'role-list',
        'role-create',
        'role-edit',
        'role-delete',
        'product-list',
        'product-create',
        'product-edit',
        'product-delete'
    ];
```

Inside the `run` method add:

```php
foreach ($this->permissions as $permission) {
    Permission::create(['name' => $permission]);
}

$role = Role::create(['name' => 'Admin']);
$permissions = Permission::pluck('id', 'id')->all();
$role->syncPermissions($permissions);
```

Create User Seeder

```php
php artisan make:seeder UserSeeder
```

Open User Seeder and add the following use lines:

```php
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;
```

Also, edit the `run` method, and add:

```php
    // Create admin User and assign the role to him.
    $user = User::create([
        'name' => 'Administrator',
        'email' => 'amin@example.com',
        'password' => Hash::make('Password1')
    ]);

    $role = Role::whereName('Admin');
    $user->assignRole([$role->id]);
```

Open Database Seeder and add the follo9wing lines immediately after the `{` of
the run() method:

```php
      $this->call([
          RoleSeeder::class, // Must be done BEFORE User Seeding
          UserSeeder::class,
      ]);
```


Routing time

Edit the web routes

just before the `require __DIR__.'/auth.php';` add:
```php
    Route::middleware('auth')->group(function () {
    Route::resource('roles', RoleController::class);
    Route::resource('users', UserController::class);
    Route::resource('products', ProductController::class);
});
```


Controllers Time

We already have a product controller, we need a Roles and an Permissions controllers:

```shell
php artisan make:controller RoleController -r
php artisan make:controller UserController -r
```

Edit the Product Controller

Update to read:

```php
<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;

class ProductController extends Controller
{
    /**
     * Define permissions for the Product Controller
     */
    function __construct()
    {
        $this->middleware(['permission:product-list|product-create|product-edit|product-delete'],
            ['only' => ['index', 'show']]);
        $this->middleware(['permission:product-create'], ['only' => ['create', 'store']]);
        $this->middleware(['permission:product-edit'], ['only' => ['edit', 'update']]);
        $this->middleware(['permission:product-delete'], ['only' => ['destroy']]);
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $products = Product::latest()->paginate(50);
        return view('products.index', compact('products'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('products.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreProductRequest $request)
    {
        request()->validate([
            'name' => 'required',
            'detail' => 'required',
        ]);

        Product::create($request->all());

        return redirect()->route('products.index')
            ->with('success', 'Product created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        return view('products.show', compact('product'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product)
    {
        return view('products.edit', compact('product'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateProductRequest $request, Product $product)
    {
        request()->validate([
            'name' => 'required',
            'detail' => 'required',
        ]);

        $product->update($request->all());

        return redirect()->route('products.index')
            ->with('success', 'Product updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        $product->delete();

        return redirect()->route('products.index')
            ->with('success', 'Product deleted successfully');
    }
}

```

Open Roles controller and update to read:

```php

```

Open user Controller and update to read:


```php

```

Views Time!

create a new admin layout template

`resources\views\layouts\admin.blade.php`

```html

```
