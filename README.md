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

> [!NOTE]
>
> This section is based on [this laravel tutorial](https://youtu.be/gHQ-OT8V5VU?si=s9XWPEKoWUUaNZJx).
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

> [!NOTE]
>
> This section is based on the [Model Factories tutorial](https://youtu.be/9O_WD5zQGxM?si=xK2WZc3FqMiXY7Q7)

The *model factory* can be used to quickly scaffold example data. This is a useful tool to quickly create a bunch of fake data (like 100 fake users).

> [!NOTE]
>
> Factories are located in the `database/factories` directory.

To create a factory use `php artisan make:factory`.

The following example will make a new factory named *JobFactory*

```php
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

> [!NOTE]
>
> This section is based on the [Two Key Eloquent Relationship Types](https://youtu.be/9ETUz-cgXI4?si=BjRkN0mSowmoDFZ2)

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

> [!NOTE]
>
> This section is based on the [Pivot Tables and BelongsToMany Relationships](https://youtu.be/x1UCiE0hZiw?si=lX4bOvKI8o9pQObe)

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

> [!NOTE]
>
> This section is based on the [Eager Loading and the N+1 Problem](https://youtu.be/gaW9KODumUg?si=jR6xCcZu_lsiS1ue)

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

> [!NOTE]
>
> This section is based on the [All You Need to Know About Pagination](https://youtu.be/oLy1uXU1q7c?si=NMg_vKJ2pakoW7yN)

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

To add links in the page, you can just add `{{ $jobs->links() }}` in your blade file containing a view.

```html
<div>
    {{ $jobs->links() }}
</div>
```

> [!WARNING]
>
> Laravel assumes that the application uses [Tailwind CSS](https://tailwindcss.com/). This is true also in case of the *pagination* functionality. *Laravel* will automatically assume that the tailwind CSS style is installed.

### Editing defalul *Laravel* views

> [!NOTE]
>
> This section is based on the [All You Need to Know About Pagination](https://youtu.be/oLy1uXU1q7c?si=NMg_vKJ2pakoW7yN)

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

## Notes

- PHP with Apache server requires root as a user therefore it's currently not possible to use it with normal user
- It seems like the CSS and JS should be put in the `public` folder
