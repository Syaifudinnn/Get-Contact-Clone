<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Paths
    |--------------------------------------------------------------------------
    |
    | Define the paths that should have CORS enabled. By default, this is set
    | to include the API routes and Sanctum CSRF cookie endpoints.
    |
    */
    'paths' => ['api/*', 'sanctum/csrf-cookie'],

    /*
    |--------------------------------------------------------------------------
    | Allowed Methods
    |--------------------------------------------------------------------------
    |
    | Controls the HTTP methods that are allowed for CORS requests. You can
    | use a wildcard (*) to allow all methods or specify them explicitly.
    |
    */
    'allowed_methods' => ['*'],

    /*
    |--------------------------------------------------------------------------
    | Allowed Origins
    |--------------------------------------------------------------------------
    |
    | Define the origins that are allowed to access your resources. You can
    | specify a wildcard (*) to allow all origins or specify specific domains.
    |
    */
    'allowed_origins' => ['*'],

    /*
    |--------------------------------------------------------------------------
    | Allowed Origins Patterns
    |--------------------------------------------------------------------------
    |
    | Patterns to match allowed origins. This is an advanced feature that
    | can be used when you want to match origins dynamically.
    |
    */
    'allowed_origins_patterns' => [],

    /*
    |--------------------------------------------------------------------------
    | Allowed Headers
    |--------------------------------------------------------------------------
    |
    | Specify the headers that are allowed in CORS requests. Use a wildcard (*)
    | to allow all headers, or list specific headers as needed.
    |
    */
    'allowed_headers' => ['*'],

    /*
    |--------------------------------------------------------------------------
    | Exposed Headers
    |--------------------------------------------------------------------------
    |
    | Headers that are allowed to be exposed to the browser in CORS responses.
    | This is typically empty unless you have specific needs.
    |
    */
    'exposed_headers' => [],

    /*
    |--------------------------------------------------------------------------
    | Max Age
    |--------------------------------------------------------------------------
    |
    | The maximum number of seconds that the results of a preflight request
    | can be cached. Set this to 0 for no caching.
    |
    */
    'max_age' => 0,

    /*
    |--------------------------------------------------------------------------
    | Supports Credentials
    |--------------------------------------------------------------------------
    |
    | Indicates whether or not the response to the request can be exposed
    | when credentials are included in the request (e.g., cookies, HTTP
    | authentication). Set this to true if using cookies for authentication.
    |
    */
    'supports_credentials' => false,

];
