<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Demande de devis</title>
</head>
<body style="font-family: Arial, sans-serif; line-height: 1.6; color: #333;">
    <div style="max-width: 600px; margin: 0 auto; padding: 20px; border: 1px solid #ddd; border-radius: 10px; background-color: #f9f9f9;">
        <h2 style="color: #1800AD; border-bottom: 2px solid #FFA500; padding-bottom: 10px;">Nouvelle demande de devis</h2>
        
        <table style="width: 100%; border-collapse: collapse; margin-top: 15px;">
            <tr>
                <td style="padding: 8px; font-weight: bold; border-bottom: 1px solid #eee; width: 150px;">Nom:</td>
                <td style="padding: 8px; border-bottom: 1px solid #eee;">{{ $data['nom'] }}</td>
            </tr>
            <tr>
                <td style="padding: 8px; font-weight: bold; border-bottom: 1px solid #eee;">Prénom:</td>
                <td style="padding: 8px; border-bottom: 1px solid #eee;">{{ $data['prenom'] }}</td>
            </tr>
            <tr>
                <td style="padding: 8px; font-weight: bold; border-bottom: 1px solid #eee;">Téléphone:</td>
                <td style="padding: 8px; border-bottom: 1px solid #eee;">{{ $data['telephone'] }}</td>
            </tr>
            <tr>
                <td style="padding: 8px; font-weight: bold; border-bottom: 1px solid #eee;">E-mail:</td>
                <td style="padding: 8px; border-bottom: 1px solid #eee;">{{ $data['email'] }}</td>
            </tr>
            @if(!empty($data['marque']))
            <tr>
                <td style="padding: 8px; font-weight: bold; border-bottom: 1px solid #eee;">Marque:</td>
                <td style="padding: 8px; border-bottom: 1px solid #eee;">{{ $data['marque'] }}</td>
            </tr>
            @endif
            @if(!empty($data['modele']))
            <tr>
                <td style="padding: 8px; font-weight: bold; border-bottom: 1px solid #eee;">Modèle:</td>
                <td style="padding: 8px; border-bottom: 1px solid #eee;">{{ $data['modele'] }}</td>
            </tr>
            @endif
        </table>

        @if(!empty($data['commentaire']))
        <div style="margin-top: 20px; padding: 15px; background-color: #fff; border-left: 4px solid #FFA500; border-radius: 4px;">
            <strong style="display: block; margin-bottom: 5px; color: #1800AD;">Commentaire:</strong>
            <p style="margin: 0; white-space: pre-wrap;">{{ $data['commentaire'] }}</p>
        </div>
        @endif
        
        <p style="font-size: 12px; color: #777; margin-top: 25px; text-align: center; border-top: 1px solid #eee; padding-top: 15px;">
            Cet e-mail a été envoyé depuis le site de Thara Motors.
        </p>
    </div>
</body>
</html>
