use App\Http\Controllers\MAController;

Route::get('/ma/{id}', [MAController::class, 'getMAData']);
 