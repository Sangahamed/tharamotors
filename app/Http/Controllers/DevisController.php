<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Mail\DevisMail;
use Illuminate\Support\Facades\Mail;

class DevisController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nom'         => 'required|string|max:100',
            'prenom'      => 'required|string|max:100',
            'telephone'   => 'required|string|max:20',
            'email'       => 'required|email|max:255',
            'marque'      => 'nullable|string|max:100',
            'modele'      => 'nullable|string|max:100',
            'commentaire' => 'nullable|string|max:2000',
        ]);

        try {
            Mail::to(config('mail.devis_recipient', 'contact@tharamotors.com'))
                ->send(new DevisMail($validated));
        } catch (\Exception $e) {
            // Logs error if mail fails, but we don't break the customer journey (WhatsApp works as fallback)
            logger()->error('Erreur lors de l\'envoi du mail de devis: ' . $e->getMessage());
        }

        // WhatsApp redirect details construction
        $message = "Bonjour, je souhaite obtenir un devis. Voici mes coordonnées :\n\n";
        $message .= "Nom : " . $validated['nom'] . "\n";
        $message .= "Prénom : " . $validated['prenom'] . "\n";
        $message .= "Téléphone : " . $validated['telephone'] . "\n";
        $message .= "E-mail : " . $validated['email'] . "\n\n";

        if (!empty($validated['marque']) || !empty($validated['modele'])) {
            $message .= "Je suis intéressé(e) par ";
            if (!empty($validated['marque'])) $message .= "la marque " . $validated['marque'] . " ";
            if (!empty($validated['modele'])) $message .= "modèle " . $validated['modele'] . ". ";
            $message .= "\n\n";
        }

        if (!empty($validated['commentaire'])) {
            $message .= "Commentaire : " . $validated['commentaire'] . "\n\n";
        }

        $message .= "Merci de me faire parvenir votre meilleure offre.";
        
        $whatsappUrl = "https://wa.me/" . config('services.whatsapp.number') . "?text=" . rawurlencode($message);

        return response()->json([
            'success' => true,
            'whatsapp_url' => $whatsappUrl
        ]);
    }
}
