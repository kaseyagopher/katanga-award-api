<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Concerns\VerifiesAdminPassword;
use App\Models\Edition;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class EditionController extends Controller
{
    use VerifiesAdminPassword;

    public function index()
    {
        $Editions = Edition::withCount(['categories', 'votes'])
            ->orderByDesc('statut')
            ->orderByDesc('created_at')
            ->get();

        return view('admin.editions', compact('Editions'));
    }

    public function edit($id)
    {
        $edition = Edition::find($id);

        if (! $edition) {
            return response()->json([
                'success' => false,
                'message' => 'Édition non trouvée.',
            ], 404);
        }

        return response()->json([
            'success' => true,
            'edition' => $edition,
        ]);
    }

    /** Ouvrir une nouvelle session (édition active). */
    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'titre' => ['required', 'string', 'max:255'],
                'theme' => ['required', 'string', 'max:255'],
                'password' => ['required', 'string'],
            ]);

            $this->verifyAdminPassword($request);

            Edition::where('statut', 1)->update(['statut' => 0]);
            session()->forget('admin_consultation_edition_id');

            $edition = Edition::create([
                'titre' => $validated['titre'],
                'theme' => $validated['theme'],
                'statut' => 1,
                'admin_id' => Auth::guard('admin')->id(),
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Session ouverte avec succès.',
                'edition' => $edition,
            ], 201);
        } catch (ValidationException $e) {
            return response()->json([
                'success' => false,
                'errors' => $e->errors(),
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erreur : '.$e->getMessage(),
            ], 500);
        }
    }

    /** Modifier titre / thème (sans changer le statut). */
    public function update(Request $request, Edition $edition)
    {
        $validated = $request->validate([
            'titre' => ['required', 'string', 'max:255'],
            'theme' => ['required', 'string', 'max:255'],
        ]);

        $edition->update($validated);

        return response()->json([
            'success' => true,
            'message' => 'Édition mise à jour avec succès.',
            'edition' => $edition,
        ]);
    }

    /** Clôturer la session active. */
    public function close(Request $request, Edition $edition)
    {
        try {
            $this->verifyAdminPassword($request);

            if ((int) $edition->statut !== 1) {
                return response()->json([
                    'success' => false,
                    'message' => 'Seule une session active peut être clôturée.',
                ], 422);
            }

            $edition->update(['statut' => 0]);

            if ((int) session('admin_consultation_edition_id') === (int) $edition->id) {
                session()->forget('admin_consultation_edition_id');
            }

            return response()->json([
                'success' => true,
                'message' => 'Session clôturée avec succès.',
            ]);
        } catch (ValidationException $e) {
            return response()->json([
                'success' => false,
                'errors' => $e->errors(),
            ], 422);
        }
    }

    /** Réactiver une session passée en mode consultation (lecture seule). */
    public function consult(Request $request, Edition $edition)
    {
        try {
            $this->verifyAdminPassword($request);

            if ((int) $edition->statut !== 0) {
                return response()->json([
                    'success' => false,
                    'message' => 'Seules les sessions clôturées peuvent être consultées.',
                ], 422);
            }

            session(['admin_consultation_edition_id' => $edition->id]);

            return response()->json([
                'success' => true,
                'message' => 'Consultation activée pour « '.$edition->titre.' ».',
                'redirect' => route('admin.dashboard'),
            ]);
        } catch (ValidationException $e) {
            return response()->json([
                'success' => false,
                'errors' => $e->errors(),
            ], 422);
        }
    }

    /** Quitter le mode consultation. */
    public function leaveConsultation()
    {
        session()->forget('admin_consultation_edition_id');

        return redirect()
            ->route('editions.index')
            ->with('success', 'Mode consultation terminé.');
    }

    public function destroy(Edition $edition)
    {
        if ((int) $edition->statut === 1) {
            return response()->json([
                'success' => false,
                'message' => 'Clôturez la session avant de la supprimer.',
            ], 422);
        }

        $edition->delete();

        if ((int) session('admin_consultation_edition_id') === (int) $edition->id) {
            session()->forget('admin_consultation_edition_id');
        }

        return response()->json([
            'success' => true,
            'message' => 'Édition supprimée avec succès.',
        ]);
    }
}
