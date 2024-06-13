<?php
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\studentController;

// obtener uno o mas estudiantes 
Route::get('/students', [studentController::class, 'index']);
 
// obtener un estudiante por id
Route::get('/students/{id}', [studentController::class, 'indexOne']);


// subir Un Estudiante
Route::post('/students', [studentController::class, 'store']);
// Route::post('/students/{id}', function (){
//     return 'Creating 1 Student';
// });

// actualizar Un Estudiante 
Route::put('/students/{id}', [studentController::class, 'updateOne']);

//actualizar el estudiante parcialmente
Route::patch('/students/{id}', [studentController::class, 'updateOnePart']);


// borrar Uno Estudiante
#Route::delete('/students', [studentController::class, 'delete']);
Route::delete('/students/{id}', [studentController::class, 'deleteOne']);

