// routes/api.php
use App\Http\Controllers\Api\StoreController;
use Illuminate\Support\Facades\Route;

// ... (route API lainnya)

Route::get('/stores/{id}', [StoreController::class, 'show']);