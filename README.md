# Laravel Actor

A brand option to have auto generated specific action fields in model. Using this package helps you universalize fields
along your team.

## Installation

In order to add the capability to your laravel application, you should require it via composer.

```shell
composer require snappshop/actor
```

### Publish configuration file

By publishing configuration file, it is possible to edit predefined custom shortcut macros.

```shell
php artisan vendor:publish --provider="SnappShop\Actor\Providers\ActorServiceProvider" --tag="actor-config"
```

## Usage

### Basic Usage

You can use actor as a macro in migrations. Verb form of action is passed as the first argument.

```php
Schema::table('users', function (Blueprint $table) {
    ...
    $table->actor('test');
    ...
});
```

In the provided example, `$table->actor('test');` will create fields `tester_id` and `tester_type`

## Shortcut Macros

You can use some macros as shortcuts. by default, `creator` and `editor` macros is defined.

```php
Schema::table('users', function (Blueprint $table) {
    ...
    $table->creator();
    $table->editor();
    ...
});
```

In the provided example, fields `creator_id`, `creator_type`, `editor_id` and `editor_type` is created for users table.

### Define Custom Shortcut Macros

use the provided config file to add or remove custom shortcut macros.

```php
return [
    'custom-macros' => [
        'edit',
        'approve',
    ]
];
```

In the provided example, the `create` macro is remove and the `approve` macro is added to the code;

## Model Traits

There is a trait provided in the package: `Actorable`. The `actorable` function is defined to handle auto-set feature.

```php
use \Snappshop\Actor\Traits\Actorable;

class User
{
    use Actorable;
    
    public function actorable(): array
    {
        return [
            'actions' => [
                'edit'
            ]
        ];
    } 
}
```

In the example above, `edit`-related fields is set on model update automatically.
Currently, The `create` action is also available to be auto-set.

## Retrieve Actor Data

Though you can access to fields directly by field name, there are some functions to access actor data.

### Available Methods:

The following methods is added by using `Actorable` trait on the model. It is totally clear that the macros in migration
should be used before to generate related columns.

#### Get Actor ID:

Retrieve actor id of given action.

```php
getActorId(string $action): int|string;

//  example output: 13
```

#### Get Actor Type:

Retrieve actor type of given action.

```php
getActorType(string $action): ?string;

//  example output: "\App\Models\User"
```

#### Get Acted At:

Retrieve the time when given action is acted at.

```php
getActedAt(string $action): ?Carbon;

//  example output: "2023-04-30 15:30:04"
```

#### Get Actor:

Retrieve the actor model.

```php
getActor(string $action): ?Model;
```

#### Get Act:

Returns an array containing all above data.

```php
getAct(string $action): array;

//  example output: [
//    'editor_id' => 13,
//    'editor_type' => "\App\Models\User",
//    'edited_at' => "2023-04-30 15:30:04",
//  ]

```

## Set Actor Data

The action field can be set with methods below.

### Touch Action

This method is provided to set all action fields at the same time with the authenticated user.

```php
touchAction(string $action, bool $isForce = false): void;
```

### Clear Action

This method is provided to clear all action fields at the same time.

```php
cleanAction(string $action): void;
```

## Check and filter Actor Data
These accessories are used for checking and filtering action data

### Check If Is Acted By
This method is used for checking if the model is acted by specific user on a specific action

```php
isActedBy(string $action, ?Authenticatable $user): bool;
```
returns `true` if the model is acted on the action by the given user.

### Acted By Scope
There is a scope provided for filtering the actorable model data to get record with the given actor on the given action.

```php
$query
...
    ->actedBy('create', $user)
...
```
The expression above scopes actorable model query with the given action and given authenticatable user.

## License

The Laravel Actor package is open-sourced software licensed under the MIT license.
