<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', [\App\Http\Controllers\DashboardController::class, 'index'])->name('dashboard');

    // Routes Partagées (Planning)
    Route::get('planning', [\App\Http\Controllers\Admin\PlanificationController::class, 'index'])->name('planification.index');

    // Routes Admin
    Route::middleware(['role:admin,super_admin,responsable_academique'])->prefix('admin')->name('admin.')->group(function () {
        Route::resource('salles', \App\Http\Controllers\Admin\SalleController::class);
        Route::resource('enseignants', \App\Http\Controllers\Admin\EnseignantController::class);
        Route::resource('etudiants', \App\Http\Controllers\Admin\EtudiantController::class);
        Route::resource('annees-academiques', \App\Http\Controllers\Admin\AnneeAcademiqueController::class);
        Route::resource('criteres', \App\Http\Controllers\Admin\CritereEvaluationController::class);
        
        // Quitus
        Route::get('quitus', [\App\Http\Controllers\Admin\QuitusController::class, 'index'])->name('quitus.index');
        Route::post('quitus/{etudiant}/valider', [\App\Http\Controllers\Admin\QuitusController::class, 'valider'])->name('quitus.valider');

        // Mémoires
        Route::get('memoires', [\App\Http\Controllers\Admin\MemoireController::class, 'index'])->name('memoires.index');
        Route::post('memoires/{memoire}/valider', [\App\Http\Controllers\Admin\MemoireController::class, 'valider'])->name('memoires.valider');
        Route::post('memoires/{memoire}/rejeter', [\App\Http\Controllers\Admin\MemoireController::class, 'rejeter'])->name('memoires.rejeter');
        Route::post('memoires/{memoire}/corrections', [\App\Http\Controllers\Admin\MemoireController::class, 'demanderCorrection'])->name('memoires.corrections');
        Route::get('memoires/{memoire}/download', [\App\Http\Controllers\Admin\MemoireController::class, 'download'])->name('memoires.download');
        Route::get('memoire-versions/{version}/download', [\App\Http\Controllers\Admin\MemoireController::class, 'downloadVersion'])->name('memoires.version.download');

        // Planification (Admin Actions only)
        Route::resource('planification', \App\Http\Controllers\Admin\PlanificationController::class)->except(['index']);
        Route::post('planification/{planification}/annuler', [\App\Http\Controllers\Admin\PlanificationController::class, 'annuler'])->name('planification.annuler');
        Route::get('etudiants/{etudiant}/theme', [\App\Http\Controllers\Admin\PlanificationController::class, 'getStudentTheme'])->name('etudiants.theme');
        
        // Export PDF
        Route::get('export/planning-hebdo', [\App\Http\Controllers\Admin\PlanificationPDFController::class, 'exportHebdo'])->name('export.planning.hebdo');

        // Paramètres globaux
        Route::get('parametres', [\App\Http\Controllers\Admin\ParametreController::class, 'index'])->name('parametres.index');
        Route::put('parametres', [\App\Http\Controllers\Admin\ParametreController::class, 'update'])->name('parametres.update');

        Route::resource('users', \App\Http\Controllers\Admin\UserController::class);
        
        // PV & Résultats
        Route::get('soutenances/{soutenance}/pv', [\App\Http\Controllers\Admin\PVController::class, 'generate'])->name('soutenances.pv');
        Route::post('soutenances/{soutenance}/publish', [\App\Http\Controllers\Admin\PVController::class, 'publish'])->name('soutenances.publish');
    });

    // Routes Enseignant
    Route::middleware(['role:enseignant'])->prefix('enseignant')->name('enseignant.')->group(function () {
        Route::get('evaluations', [\App\Http\Controllers\Enseignant\EvaluationController::class, 'index'])->name('evaluations.index');
        Route::get('evaluations/{soutenance}', [\App\Http\Controllers\Enseignant\EvaluationController::class, 'evaluate'])->name('evaluations.evaluate');
        Route::post('evaluations/{soutenance}/store', [\App\Http\Controllers\Enseignant\EvaluationController::class, 'store'])->name('evaluations.store');
        Route::post('evaluations/{soutenance}/validate', [\App\Http\Controllers\Enseignant\EvaluationController::class, 'validateNotes'])->name('evaluations.validateNotes');
        Route::post('evaluations/{soutenance}/deliberate', [\App\Http\Controllers\Enseignant\EvaluationController::class, 'deliberate'])->name('evaluations.deliberate');
        Route::get('evaluations/{soutenance}/memoire', [\App\Http\Controllers\Enseignant\EvaluationController::class, 'downloadMemoire'])->name('evaluations.memoire');
        Route::post('evaluations/{soutenance}/availability', [\App\Http\Controllers\Enseignant\EvaluationController::class, 'updateAvailability'])->name('evaluations.availability');
    });

    // Routes Étudiant
    Route::middleware(['role:etudiant'])->prefix('etudiant')->name('etudiant.')->group(function () {
        Route::get('memoire', [\App\Http\Controllers\Etudiant\MemoireController::class, 'index'])->name('memoire.index');
        Route::post('memoire', [\App\Http\Controllers\Etudiant\MemoireController::class, 'store'])->name('memoire.store');
        Route::get('memoire/view', [\App\Http\Controllers\Etudiant\MemoireController::class, 'viewFile'])->name('memoire.view');
        Route::get('memoire/download', [\App\Http\Controllers\Etudiant\MemoireController::class, 'download'])->name('memoire.download');
    });
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Notifications
    Route::get('/notifications', [\App\Http\Controllers\NotificationController::class, 'index'])->name('notifications.index');
    Route::post('/notifications/{id}/read', [\App\Http\Controllers\NotificationController::class, 'markAsRead'])->name('notifications.markAsRead');
    Route::post('/notifications/read-all', [\App\Http\Controllers\NotificationController::class, 'markAllAsRead'])->name('notifications.markAllAsRead');
});

require __DIR__.'/auth.php';
