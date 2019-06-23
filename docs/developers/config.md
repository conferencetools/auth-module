# Define permissions

The following config snippet is used to add permissions. Anywhere that a permission is
referred to in code, use it's key. The display name will be used where a permission is
displayed in the UI (eg when managing users)

```php
'auth' => [
    'permissions' => [
        'permission-key' => 'Display Name'
    ],
]
```

# Setup redirects

The following config snippet can be used to determine where a user is directed to after
a) Login and b) Change of password. (The same route will be used for both) The route should
require no parameters. 

```php 

'auth' => [
    'redirects' => [
        'default' => 'route-name',
        'byPermission' => [
            'permission' => 'route-name'
        ]
    ]
]

```

If a user has the permission listed in the key, they will be redirected to the route specified.
If a user matches multiple permissions, the route used will be the first match. If a user
matches none of the permission based routes, they will be directed to the default route.

As a minimum there must be a default route specified for login to function.