# Silly Laravel project

The very basic *Laravel* project for learning purposes. It contains the notes with description of most important steps in the *Laravel* project.

> [!IMPORTANT]
> Obviously, don't use it in production!

## First steps

### Create Docker image

> [!IMPORTANT]
>
> - Create `.env` file with configuration in the `./app` directory. You can use `.env.example` file as a starting point. Just use `cp .env.example .env`.
> - Create and export *MySql* root password by calling `export DB_ROOT_PASSWORD=root-password` **use your own password here!**
> - Export `UID` to expose the user id as an environment variable by calling `export UID=${UID}`[^1].

Run the following command to compile and run the complete suite

```sh
docker compose build && docker compose up -d
```

> [!NOTE]
>
> Visit [silly-damp](https://github.com/psugrg-web/silly-damp) for more information on the docker image for this project.

### Initialize the application

Attach to the application container, got to the `app` directory and perform the following steps

Install *composer* packages

```sh
composer install
```

Generate application key

```sh
php artisan key:generate
```

Migrate database (initialize)

```sh
php artisan migrate
```

> [!TIP]
>
> Navigate to [localhost:8080](localhost:8080) in your browser to access the application, and [localhost:8081](localhost:8081) to access *phpMyAdmin*.

[^1]: This should be done even if there's an automatic Bash `UID` read only variable present since it is ignored by the docker.

## Most important steps

### Configuration file

The configuration is stored in the `.env` file inside the `app` directory.

> [!IMPORTANT]
>
> Update the configuration file when pushed to production (like i.w. the `LOG_LEVEL=debug` entry in the `.env` file)

### Laravel Debug Bar

Debug bar is helps you debug your *Laravel* project. Find details [on the github page](https://github.com/barryvdh/laravel-debugbar).

> [!IMPORTANT]
>
> Remember to disable debug function on production `APP_DEBUG=false` in the `.env` file.

### Artisan

The *Laravel* project contains the `artisan` tool to help you configure your application.

Run the following command from the `/app` directory to see all options the *artisan* has.

```sh
php artisan
```

> [!IMPORTANT]
>
> The *artisan* command is available *only* from the directory of your *Laravel* application. In this case it's the `/app` directory.

### Tinker

The *Artisan Tinker* is the *Laravel* environment you can use to access the *runtime* environment of your application.

> [!TIP]
>
> Use it as a playground where you can quickly test your ideas.

Use `php artisan tinker` command to run it.

### Reusable components

> [Video](https://youtu.be/H5R3vV38QiM?si=wdhI5tmlLRCMnhiw)  
> [Laravel docs](https://laravel.com/docs/11.x/blade#main-content)

Reusable components are like a blue-prints for components with *slots* that can be set to different values when used. They are `blade` components that can be reused using the `x-` prefix i.e. `<x-button href="/jobs/create">Add New Job Offer</x-button>`.

Reusable components should be located in the `app/resources/views/components` directory (create it if it doesn't exist).

Within the blade component file we specify where the *slot* will be inserted. The slot is everything is in-between of the tag, e.g. `<x-example>this is the slot text</x-example>`. The slot can be inserted in the blade component by using the `{{ $slot }}`.

### Database

The database is configured during the project initialization. In case of this project, the *MySql* has been selected.

Run `php artisan db::show` to get the information about the database configuration.

### Migrations

Migrations essentially are the automation to control your database. Use it to create, delete or update yor DB.

#### Reset DB and start from scratch

> [!CAUTION]
>
> This will destroy all entries in the DB, use it carefully!

Execute `php artisan migrate:refresh` to drop all your entries and re-run all migrations.

#### Rollback las migration

Execute `php artisan migrate:rollback` to revert the last migration.

#### Create migration

Run `php artisan make:migration` to create new migration (migration file). Type a name e.g. `create_flights_table` and hit enter.

##### Add new fields in the new table

Open the file that has been created and edit the `up()` method. Add as many fields as you need.

To add a new *string* field named *title*, add the following to the migration file:

```php
$table->string('title');
```

#### Run migrations

Execute `php artisan migrate` to run all migrations. This will re-configure your database (or create it from scratch if it doesn't exist).

### Models & Eloquent ORM (Object Relational Mapper)

The *Eloquent* ORM is used to define **models**[^2] for our application.

> [Video](https://youtu.be/gHQ-OT8V5VU?si=s9XWPEKoWUUaNZJx).
>
> Example object is defined in [Job.php](./app/app/Models/Job.php) file.
>
> Details can be found on [the *Eloquent* documentation site](https://laravel.com/docs/11.x/eloquent).

#### Automatic model generation

> [!NOTE]
>
> Most likely this is the most useful way of creating models.

The *Laravel* project comes with the `make:model` *artisan* utility that can be use to automatically create the model.

Use `php artisan make:model Comment` to create a new *model* named *Comment*. This will create a new file `app/Models/Comment.php` that will contain the *model*.

> [!TIP]
>
> The `artisan make:model` can automatically create not only the *model*, but also *migration*, *controller* and more.

Use `php artisan make:model Post -m` to create new *model* named *Post* and a corresponding *migration*. This will create new files `app/Models/Post.php` and `database/migrations/2024_03_1234_create_posts_table.php` that will contain the *model* and the corresponding *migration*.

> [!TIP]
>
> Use `artisan help make:model` to learn more about this utility.

#### Manual model generation

> [!NOTE]
>
> Most likely you'll never do it manually.

Extend the `Model` class to create a new model.

```php
class Item extends Model {
}
```

> [!TIP]
>
> With *Eloquent* you can access tables and fields in the DB without a need of implementing a complete structure of the model in the code. It'll be created for you by the *Eloquent*.

[^2]: Model as in the Model View Controller

#### Naming convention for automatic table name detection

> [!IMPORTANT]
>
> *Eloquent* can **automatically** get the name of the *table* in the DB from the name of the *model* class!

If you want the *Eloquent* to automatically detect the name of the table in the DB, you must name your class accordingly to the naming convention:

|Table name in DB| Class name in the model |
|----------------|-------------------------|
|my_items        | MyItem                  |

> [!IMPORTANT]
>
> Note the **s** in the table name and the lack of it in the class name!
>
> Eloquent uses the *CamelCase* notation and expects the table to use the *hungarian notation*.
> It also expects the table name to be plural and the class name to be singular

#### Explicit table name in the model

Instead of letting the *Eloquent* to automatically detect the name of the table from the name of the class, it's possible to explicitly specify the table name bu using the `protected $table` variable in the object class.

```php
class Item extends Model {
    protected $table = 'my_items';
}
```

#### Naming convention for fields

*Eloquent* is able to access individual entries from the table just by using the name of the field.

```php
$jobs = Job::all();
dd($jobs[0]->title);
```

The code above will access the `title` field in the first entry in the table.

> [!IMPORTANT]
>
> In this case, the naming convention requires the name of the field in the table to match exactly the name of the field in the code.

#### Fields mass assignments

Bu default *Laravel* prevents fields mass assignments to protect the DB from the malicious changes that could sneak into the DB by using this method.

In order to use mass assignment, the model class must specify fields that are safe to be mass assigned. Do that by adding names of these fields to the `protected $fillable` variable.

```php
protected $fillable = ['title', 'salary'];
```

This will inform *Eloquent* that only those fields can be mass assigned.

Example of the mass assignment in the [Tinker](#tinker) utility:

```php
App\Models\Job::create(['title' => 'Acme Director', 'salary' => '$1,000,000']);
```

The above code will result in an update of the DB table:

```php
= App\Models\Job {#5225
    title: "Acme Director",
    salary: "$1,000,000",
    updated_at: "2025-01-01 16:23:15",
    created_at: "2025-01-01 16:23:15",
    id: 4,
  }
```

Alternatively you can choose the opposite approach and define fields that are guarded by using the `$guarded` field.

```php
protected $guarded = ['employer_id'];
```

> [!WARNING]
>
> Defining the empty `$guarded` field will **disable** the mass assignment protection feature.

#### Finding specific record

Use the `find($id)` method to find the record by *ID*.

Example of the mass assignment in the [Tinker](#tinker) utility:

```php
$job = App\Models\Job::find(4);
```

The above code will result in the listing of the entry:

```php
= App\Models\Job {#5210
    id: 4,
    title: "Acme Director",
    salary: "$1,000,000",
    created_at: "2025-01-01 16:23:15",
    updated_at: "2025-01-01 16:23:15",
  }
```

Now the `$job` variable will contain the entry that was found.

#### Delete entry

Use `delete()` method on the entry object to delete it `$job->delete()`.

### Model Factories

> [Video](https://youtu.be/9O_WD5zQGxM?si=xK2WZc3FqMiXY7Q7)

The *model factory* can be used to quickly scaffold example data. This is a useful tool to quickly create a bunch of fake data (like 100 fake users).

> [!NOTE]
>
> Factories are located in the `database/factories` directory.

To create a factory use `php artisan make:factory`.

The following example will make a new factory named *JobFactory*

```sh
php artisan make:factory JobFactory
```

> [!TIP]
>
> Use `php artisan help make:factory` to get extra details.

To use that factory call `App\Models\Job::factory()->create()` in the *artisan tinker* tool.

```php
App\Models\Job::factory()->create()
```

The example above will create one fake job entry in the DB.

If you add a number as an argument to the `factory()` method, you'll ask *Laravel* to create a number of entries.

```php
App\Models\Job::factory(100)->create()
```

To create a variant of the object in the DB you can call a a specific function from the factory that creates this variant.

```php
App\Models\User::factory()->unverified()->create()
```

The example above will create a user with an unverified email address.

#### Relations to other models

> [!TIP]
>
> More on that in the [Eloquent relationships](#eloquent-relationships) chapter

If your model has a relation to other models, you can reflect that in the factory by calling the factory of the other model.

```php
class JobFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title' => fake()->jobTitle(),
            'employer_id' => Employer::factory(),
            'salary' => '$50,000 USD'
        ];
    }
}
```

The example above will create a new *employer* and assign his ID to the fild of the *job* object.

The following example will create a ten *job* entries and ten *employers* entries each one assigned to a corresponding *job* entry.

```php
App\Models\Job::factory(10)->create()
```

> [!TIP]
>
> If you want *job* entries to share the same *employer* you can make use of the `recycle()` method. The following example will create three *job* entries sharing the common *employer*
>
> ```php
> App\Models\Job::factory(3)->recycle(App\Models\Employer::factory()->create())->create()
> ```

### Eloquent relationships

> [Video](https://youtu.be/9ETUz-cgXI4?si=BjRkN0mSowmoDFZ2)

Eloquent relationships are a vay of handling relations between models (DB objects).

The relation is defined in the model and in the migration.

#### Relation definition in the migration

The migration can define a relation to other model i.e. by using a `foreignIdFor()` method.

```php
public function up(): void
{
    Schema::create('job_listings', function (Blueprint $table) {
        $table->id();
        $table->foreignIdFor(\App\Models\Employer::class);
        $table->string('title');
        $table->string('salary');
        $table->timestamps();
    });
}
```

Above example shows how to add a relation to the `Employer` class by using its ID stored in the DB. Eloquent is able to automatically understand this and search for the related objet by referring to that ID.

#### Belongs-To relation in the model

The model must also be modified in order to understand the relation to the other object. You can use it by implementing a getter function that will return the related object.

```php
public function employer()
{
    return $this->belongsTo(Employer::class);
}
```

This method uses the built in `belongsTo()` method that will ask *Eloquent* to perform a new query to search the database for the object referred by the ID stored in the field defined by the migration.

> [!IMPORTANT]
>
> The name of the getter function **must** follow the name of the class it relates to. I.e. for the class named ***Employer*** it must be named ***employer***; for the class named ***JobCategory*** it must be named ***jobCategory***.

In order to use it you must call it as if you were accessing a property `$job->employer`, not a function call.

```php
$job = App\Models\Job::first();
$job->employer;
```

Using it this way will instruct *Laravel* to perform that search and retrieve the *Employer* object.

#### Has-Many relation in the model

The *Employer* model has a similar relation to the *Job* class but it can have *many* of such *Job* objects.

In such situation, where a model has relation *one-to-many*, implement it in the model using the `hasMany()` method.

```php
public function jobs()
{
    return $this->hasMany(Job::class);
}
```

Use it in a similar way as in the example above.

```php
$employer = App\Models\Employer::first();
$employer->jobs;
```

This will return the *Laravel* collection object containing the list of all *Jobs* related to that *Employer*.

> [!TIP]
>
> Remember to access it as if it was a property `$employer->jobs`, otherwise it will not work correctly.

### Pivot tables

> [Video](https://youtu.be/x1UCiE0hZiw?si=lX4bOvKI8o9pQObe)

Pivot table connects two other tables logically. In case of this example project you can connect *jobs* with *tags* via the pivot table.

> [!TIP]
>
> Pivot table can have it's ovn migration file or it can be integrated with the other migration. In our case it's integrated with the *tags* table migration.

#### Belong-To-Many relation

Pivot table is an example of a belongs-to-many relation. One job may belong to many tags but also one tag may belong to many jobs.

This type of relation is coded using the `belongsToMany()` method in the model class. 

```php
class Tag extends Model
{
    /** @use HasFactory<\Database\Factories\TagFactory> */
    use HasFactory;

    public function jobs()
    {
        return $this->belongsToMany(Job::class);
    }
}
```

```php
class Job extends Model
{
    use HasFactory;

    // Explicitly specify the name of the table in the DB (in case it cannot be deduced automatically)
    protected $table = 'job_listings';
    // Specify fields that can be mass-assigned
    protected $fillable = ['title', 'salary'];

    public function employer()
    {
        return $this->belongsTo(Employer::class);
    }

    public function tags()
    {
        return $this->belongsToMany(Tag::class);
    }
}
```

> [!NOTE]
>
> In our case we must explicitly specify the `foreignPivotKey` and the `relatedPivotKey` since the name of the Job class is no following the convention and provides a custom name `job_listings` for the table.
>
> ```php
> return $this->belongsToMany(Tag::class, foreignPivotKey: "job_listing_id");
> ```
>
> ```php
> return $this->belongsToMany(Job::class, relatedPivotKey: "job_listing_id");
> ```

##### Get the list of elements from the pivot table

Use it in a similar way as the other relations

```php
$tag = App\Models\Tag::find(1);
$tag->jobs;
```

This example will get the list of all jobs attached to that tag.

In case you want to get only the job titles associated with that tag, use the `pluck()` method.

```php
$tag->jobs()->get()->pluck('title');
```

##### Attach new record to the pivot table

Use the `Attach()` method to attach new object and create a new entry in the pivot table. This method expects the ID of the element to attach, so either of those will work.

```php
$tag->jobs()->attach(7);
```

```php
$tag->jobs()->attach(App\Models\Job::find(7));
```

> [!IMPORTANT]
>
> *Laravel* uses cache and will not reach for the new data when using the standard `$tag->jobs`. In order to invalidate the cache and force *Laravel* to refetch the data from DB, use `$tag->jobs()->get()`.

### SQL constraints

[SQL constraints](https://www.w3schools.com/sql/sql_constraints.asp) are used to specify rules for data in a table.

It's commonly used to cascade a delete action performed on one DB entry to a related DB entry that cannot exists without the first one.

In *Laravel* you can use the `constrained()` function in the migration file and select a desired constrain.

```php
Schema::create('job_tag', function (Blueprint $table) {
    $table->foreignIdFor(\App\Models\Tag::class)->constrained()->cascadeOnDelete();
});
```

The example above makes a new table `job_tag` and adds an entry containing the foreign ID of the *Tag* class. It also creates a constrain that it should cascade the delete process. This way, if a `tag` entry will be deleted, the corresponding `job_tag` entry will also be deleted.

> [!IMPORTANT]
>
> Please make sure that the constraints are enabled in your DB engine. They are enabled by default in *MySQL* but disabled in *SQLite*. To enable it in *SQLite*, call `PRAGMA foreign_keys=on` in your *SQLite* client app.

### N+1 problem

> [Video](https://youtu.be/gaW9KODumUg?si=jR6xCcZu_lsiS1ue)

The N+1 problem is often caused by the not optimal number of queries to database related to lazy loading mechanism in *Eloquent*. It will try to not to load anything more than it currently needs.

This means that in case where there's a relation between elements each element will be loaded individually and then also it's relation will be loaded individually. This will generate huge (N+1) number of queries.

To fix that we must implement eager loading. We must instruct *Laravel* to get all entries at once together with related entries.

```php
Route::get('/jobs', function () {
    // Prevent the N+1 problem by getting all the jobs in one query and also instructing Laravel to gen all employers that will also be needed
    $jobs = Job::with('employer')->get();
    return view('jobs', [
        'jobs' => $jobs,
    ]);
});
```

The code above will create only two queries: one for loading all jobs and second one for loading all employers that are related to jobs.

#### Disabling lazy-loading

It's possible to disable *lazy loading* globally. Some developers do that but it seems like there's still a discussion that has no conclusion.

> [!IMPORTANT]
>
> You should choose either the lazy-loading mechanism should be enabled or disabled in your project mindfully. If you choose to keep it, you should be aware of the N+1 problem.

To disable lazy-loading, go to the `AppServiceProvider.php` file located in the `/app/Providers` directory.

```php
/**
 * Bootstrap any application services.
 */
public function boot(): void
{
    // Disable lazy-loading
    Model::preventLazyLoading();
}
```

After disabling lazy-loading, *Laravel* will warn you every time you implement something that will trigger lazy-loading mechanism, forcing you to implement the eager-loading instead.

> [!TIP]
>
> The `AppServiceProvider.php` file is used to configure the application.

### Pagination

> [Video](https://youtu.be/oLy1uXU1q7c?si=NMg_vKJ2pakoW7yN)

[Pagination](https://en.wikipedia.org/wiki/Pagination), also known as paging, is the process of dividing a document into discrete pages, either electronic pages or printed pages.

In *Laravel* pagination is simple, enable it by using `paginate()` method in your *route* file. Here's an example from the `app/routes/web.php` file.

```php
Route::get('/jobs', function () {
    $jobs = Job::with('employer')->paginate(3);
    return view('jobs', [
        'jobs' => $jobs,
    ]);
});
```

> [!TIP]
>
> You can specify the order the elements will be provided to the paginator, i.e. `latest()` will provide the most recently changed entries first `$jobs = Job::with('employer')->latest()->paginate(3);`.

To add links in the page, you can just add `{{ $jobs->links() }}` in your blade file containing a view.

```html
<div>
    {{ $jobs->links() }}
</div>
```

> [!WARNING]
>
> Laravel assumes that the application uses [Tailwind CSS](https://tailwindcss.com/). This is true also in case of the *pagination* functionality. *Laravel* will automatically assume that the tailwind CSS style is installed.

### Editing defalut *Laravel* views

> [Video](https://youtu.be/oLy1uXU1q7c?si=NMg_vKJ2pakoW7yN)

In case you don't use the [Tailwind CSS](https://tailwindcss.com/), which is assumed by *Laravel* to be the default style engine, you must edit *Laravel* views manually. You can select other style engine or just use your own style and build view manually.

> [!NOTE]
>
> The *Laravel* views are not by default accessible to the developer. If you want to modify them, you must first publish them so that they are publicly available.

To publish views use the `php artisan vendor:publish` command and select whatever component you want to publish. In our example it's the `Tag: laravel-pagination` view.

```sh
~/project/app$ php artisan vendor:publish

 ┌ Which provider or tag's files would you like to publish? ─────┐
 │ pagination                                                    │
 ├───────────────────────────────────────────────────────────────┤
 │   Provider: Illuminate\Pagination\PaginationServiceProvider   │
 │ › Tag: laravel-pagination                                     │
 └───────────────────────────────────────────────────────────────┘
```

The published views are copied to the `resources/views/vendor/pagination` directory.

You can either select a new view that uses a different technology (like Bootstrap) or select a custom one by modifying the `boot()` method in the `AppServiceProvider.php` file. You can also tweak an existing view by modifying the view blade file i.e. `app/resources/views/vendor/pagination/tailwind.blade.php`.

Select *Bootstrap* view by adding `Paginator::useBootstrap()` to the `boot()` method in the `AppServiceProvider.php` file.

Select a custom view by adding `Paginator::defaultView('pagination::default')`  to that file.

```php
/**
 * Bootstrap any application services.
 */
public function boot(): void
{
    // Set the custom Paginator view
    Paginator::defaultView('pagination::my-default');
}
```

### Database seeders

> [Video](https://youtu.be/wYLkf75lpT8?si=DT2vyAGoCeTuo6gj)

Database seeders are another way of populating the database with fake data. Hovewer, they can populate not only one collection, they can populate the entire DB.

> [!NOTE]
>
> Database seeders are useful to set a desired state of the DB. It can be used to set a certain test conditions.

Database seeders are located in the `app/database/seeders` path. You can find a default seeder in `DatabaseSeeder.php` file. To run it, use `php artisan db:seed` in your terminal.

In case you want start fresh and perform the database seed operation (and this is usually the case), you may just use the `--seed` option in the `php artisan migrate:fresh` command

```sh
php artisan migrate:fresh --seed
```

> [!NOTE]
>
> You can either extend the default seeder or create a new one. The new one can be a separate seeder or it can be included to the default seeder.

#### Make seeder

Use `php artisan make:seeder` command to create a standalone seeder class.

To run seeder in isolation use `php artisan db:seed --class=JobSeeder` (where `JobSeeder` is the name of the seeder class that you want to trigger).

> [!TIP]
>
> Isolated seeders can be used to prepare a specific state of the DB to perform a specific test.

### Wildcard routes

> [Video](https://youtu.be/pcZEC_AkZeA?si=CcGwuYoNhZlj8KLw)

Wildcard routes are routs that can get any parameter as an input and process it in a dedicated view.

```php
Route::get('/jobs/{id}', function ($id) {

    $job = Job::find($id);

    return view('job', ['job' => $job]);
});
```

The code above creates a route to a specific *job* of the *id* provided in {id}. Note that it can accept anything hence it is a wildcard.

> [!IMPORTANT]
>
> Wildcard routs must be declared after more specific routes otherwise the specific route will never be called. The request will be consumed by the wildcard route.

### Folders structure & naming convention

> [Video](https://youtu.be/pcZEC_AkZeA?si=CcGwuYoNhZlj8KLw)

General convention for views is to name the folder with the name of the view it represents i.e. `jobs` folder will contain views related to displaying jobs. Files (views) should be named after the action they're performing. i.e. `index.blade.php` to display the list of jobs, `show.blade.php` for displaying a single job, `create.blade.php` for creating a new job entry etc.

```text
> views
    > jobs
        index.blade.php
        show.blade.php
        create.blade.php
```

> [!TIP]
>
> You can use `.` for folder separation instead of `/`, e.g. `jobs.index` instead of `jobs/index`.

### CSRF

> [Video](https://youtu.be/pcZEC_AkZeA?si=CcGwuYoNhZlj8KLw)  
> [Laravel docs](https://laravel.com/docs/11.x/csrf#main-content)

The [CSRF](https://pl.wikipedia.org/wiki/Cross-site_request_forgery)(Cross-site request forgery), also known as one-click attack or session riding and abbreviated as CSRF (sometimes pronounced sea-surf[1]) or XSRF, is a type of malicious exploit of a website or web application where unauthorized commands are submitted from a user that the web application trusts.

> [!NOTE]
>
> *Laravel* has a built-in mechanism that prevents that from happening

When posting a form we must use a special CSRF token that validates the request in order for the POST request to be accepted by the *Laravel*. To request the token use the `@csrf` *Laravel* directive in the *form* body.

```php
<form method="POST" action="/jobs">
    @csrf
```

### Request validation

> [Video](https://youtu.be/tROESL4trkQ?si=kHOHiC_aaAnXFAjT)  
> [Laravel docs](https://laravel.com/docs/11.x/validation)

Use `request()->validate()` to request *Laravel* to validate the data included in the request.

```php
request()->validate([
    'title' => ['required', 'min:3'],
    'salary' => ['required']
]);
```

The code above will expect two entries: `title` and `salary`, both are required, first one should be at least three characters long.

#### Displaying validation errors

Use `$errors` variable that contains errors (if any) to inform the user of any validation errors.

> [!NOTE]
>
> The `$errors` variable is **always** available, even if there are no errors.

```php
@if ($errors->any())
    @foreach ($errors->all() as $error)
        <span>{{ $error }}</span>
    @endforeach
@endif
```

The example above will display all errors stored in the `$errors` variable.

Instead of printing all errors in one go, you can print a specific error, related to a specific tag.

```php
@error('title')
    {{ $message }}
@enderror
```

The example above will print only error related to the `title` tag.

### Patch & Delete requests

> [Video](https://youtu.be/syx1tWSZbL8?si=Yc2qbRCADIvcop5n)

The *Patch* and *Delete* requests are not automatically handled by the web browser. They are added by the *Laravel* framework on top of existing native mechanisms.

> [!NOTE]
>
> Web browsers natively supports only *get* and *put* requests.

#### Patch

##### Patch handling in the routes file

Use *patch* request in the routes file to handle the update request of a DB entry

```php
Route::patch('/jobs/{id}', function ($id) {
    request()->validate([
        'title' => ['required', 'min:3'],
        'salary' => ['required']
    ]);

    // Authorize (not shown in this example)

    $job = Job::findOrFail($id);

    $job->update([
        'title' => request('title'),
        'salary' => request('salary'),
    ]);

    // Redirect to the job page
    return redirect('/jobs/' . $job->id);
});
```

> [!NOTE]
>
> The `findOrFail()` method will fail when requested object is not found. The *Laravel* will redirect automatically to the error page.

##### Patch handling in the view file

Since web browsers don't natively support the *patch* request, me must use a tweaked *post* request instead, to satisfy the browser and at the same time pass the information that this is actually a *patch* request to the route file (*Laravel* framework). This is done by using the `@method('PATCH')` directive.

```html
<form method="POST" action="/jobs/{{ $job->id }}">
    @csrf
    @method('PATCH')
```

#### Delete handling in the routes file

Use *delete* request in the routes file to handle the delete request of an entry

```php
Route::delete('/jobs/{id}', function ($id) {

    // authorize (Not shown in this example)

    $job = Job::findOrFail($id)->delete();

    return redirect('/jobs');
});
```

##### Delete handling in the view file

Since web browsers don't natively support the *delete* request, me must use a tweaked *post* request instead, to satisfy the browser and at the same time pass the information that this is actually a *delete* request to the route file (*Laravel* framework). This is done by using the `@method('DELETE')` directive.

```html
<div>
    <nav><button form="delete-form">Delete Job</button></nav>
</div>
<form method="POST" action="/jobs/{{ $job->id }}" id="delete-form" class="hidden">
    @csrf
    @method('DELETE')
</form>
```

> [!TIP]
>
> Note that the *button* doesn't need to be within the *form*, it can be anywhere on the page. Note also that the form is *hidden*.

### Route Model Binding

> [Video](https://youtu.be/0edxA7D_RvQ?si=RNK7fVsmD7Nxbyz5)  
> [Laravel docs](https://laravel.com/docs/11.x/folio#route-model-binding)

The following code:

```php
Route::get('/jobs/{id}', function ($id) {
    $job = Job::find($id);
    return view('jobs.show', ['job' => $job]);
});
```

Is something that is used many times across all projects. *Laravel* can support developer providing a common convention for that. So that the code can be replaced with:

```php
Route::get('/jobs/{job}', function (Job $job) {
    return view('jobs.show', ['job' => $job]);
});
```

Pay attention to the change `id` -> `job`. By following the naming convention, *Laravel* can understand that you're trying to access a single entry in the DB. By using a type in a function parameter we instruct *Laravel* to use the *Job* class to find it.

> [!TIP]
>
> You can configure this functionality. More on that in the video or in Laravel documentation.

### Controller Classes

> [Video](https://youtu.be/0edxA7D_RvQ?si=RNK7fVsmD7Nxbyz5)  
> [Laravel docs](https://laravel.com/docs/11.x/controllers#main-content)

Create controller by using `php artisan make:controller`.

> [!NOTE]
>
> You can also do it when making a model by adding `-c` option to the `php artisan make:model` command.

Name your controller by adding the name of the controller and add `Controller` at the end, e.g. `JobController`.

Select `Empty` as a starting point, or read the documentation to learn more.

In the controller class you can implement the logic for handling requests (instead of keepin it all in the route file).

Routes file:

```php
Route::get('/jobs', [JobController::class, 'index']);
```

Controller:

```php
class JobController extends Controller
{
    public function index()
    {
        // Prevent the N+1 problem by getting all the jobs in one query and also instructing Laravel to gen all employers that will also be needed
        $jobs = Job::with('employer')->latest()->paginate(3);
        return view('jobs.index', [
            'jobs' => $jobs,
        ]);
    }
}
```

### Route view

> [Video](https://youtu.be/0edxA7D_RvQ?si=RNK7fVsmD7Nxbyz5)

For static pages, where we just want a simple view, we may use `Route::view()` instead of `Route::get()` int the route file.

This:

```php
Route::get('/', function () {
    return view('home');
});
```

is equivalent to that:

```php
Route::view('/', 'home');
```

### List your routes

> [Video](https://youtu.be/0edxA7D_RvQ?si=RNK7fVsmD7Nxbyz5)

If you want to list all your routs within the project, use the `php artisan route:list` command. Use `--except-ventor` option to hide routes from external packages.

### Route groups

> [Video](https://youtu.be/0edxA7D_RvQ?si=RNK7fVsmD7Nxbyz5)

You can group routes to avoid repetitions.

This:

```php
Route::controller(JobController::class)->group(function () {
    Route::get('/jobs', 'index');
    Route::get('/jobs/create', 'create');
    Route::get('/jobs/{job}', 'show');
    Route::post('/jobs', 'store');
    Route::get('/jobs/{job}/edit', 'edit');
    Route::patch('/jobs/{job}', 'update');
    Route::delete('/jobs/{job}', 'destroy');
});
```

Is equivalent to that:

```php
Route::get('/jobs', [JobController::class, 'index']);
Route::get('/jobs/create', [JobController::class, 'create']);
Route::get('/jobs/{job}', [JobController::class, 'show']);
Route::post('/jobs', [JobController::class, 'store']);
Route::get('/jobs/{job}/edit', [JobController::class, 'edit']);
Route::patch('/jobs/{job}', [JobController::class, 'update']);
Route::delete('/jobs/{job}', [JobController::class, 'destroy']);
```

### Route resource

> [Video](https://youtu.be/0edxA7D_RvQ?si=RNK7fVsmD7Nxbyz5)

Laravel can automatically handle routes for a typical (Restful or Resourceful) controller!

This code:

```php
Route::resource('jobs', JobController::class);
```

Is equivalent to that one:

```php
Route::controller(JobController::class)->group(function () {
    Route::get('/jobs', 'index');
    Route::get('/jobs/create', 'create');
    Route::get('/jobs/{job}', 'show');
    Route::post('/jobs', 'store');
    Route::get('/jobs/{job}/edit', 'edit');
    Route::patch('/jobs/{job}', 'update');
    Route::delete('/jobs/{job}', 'destroy');
});
```

> [!IMPORTANT]
>
> The `Route::resource` assumes that the controller has *index, create, show, store, edit, update* and *destroy* route handlers implemented!

If you don't need all of these routes, you can specify a list of available routs by using the `'only' => []` mapping, or you can specify the list of missing routes by using the `'except' => []` mapping.

```php
Route::resource('jobs', JobController::class, [
    'only' => ['index', 'show', 'create', 'store']
]);
```

```php
Route::resource('jobs', JobController::class, [
    'except' => ['edit']
]);
```

## Notes

- PHP with Apache server requires root as a user therefore it's currently not possible to use it with normal user
- It seems like the CSS and JS should be put in the `public` folder
