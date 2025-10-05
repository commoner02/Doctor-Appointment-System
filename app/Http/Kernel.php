protected $routeMiddleware = [
    // ... existing middleware
    'patient' => \App\Http\Middleware\CheckPatient::class,
    'doctor' => \App\Http\Middleware\CheckDoctor::class,
    'admin' => \App\Http\Middleware\CheckAdmin::class,
];