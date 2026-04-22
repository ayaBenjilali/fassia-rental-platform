<!DOCTYPE html>
<html>
<head>
    <style>
        body { font-family: 'Playfair Display', serif; background-color: #f8f5f0; color: #2A0B1A; margin: 0; padding: 0; }
        .container { max-width: 600px; margin: 40px auto; background: #ffffff; border: 1px solid #e5e7eb; border-radius: 12px; overflow: hidden; box-shadow: 0 4px 6px rgba(0,0,0,0.05); }
        .header { background-color: #2A0B1A; padding: 30px; text-align: center; }
        .header h1 { color: #D4AF37; margin: 0; font-size: 24px; letter-spacing: 2px; text-transform: uppercase; }
        .content { padding: 40px; line-height: 1.6; }
        .content h2 { color: #2A0B1A; font-size: 20px; }
        .footer { background-color: #f9fafb; padding: 20px; text-align: center; font-size: 12px; color: #9ca3af; border-top: 1px solid #f3f4f6; }
        .button { display: inline-block; padding: 12px 24px; background-color: #104B3E; color: #ffffff; text-decoration: none; border-radius: 6px; font-weight: bold; margin-top: 20px; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>L'Fassia</h1>
        </div>
        <div class="content">
            <h2>Bienvenue dans l'univers de l'élégance, {{ $user->prenom }} !</h2>
            <p>Nous sommes ravis de vous compter parmi les membres privilégies de la Maison L'Fassia.</p>
            <p>Votre compte a été créé avec succès. Vous pouvez désormais explorer nos collections exclusives et gérer vos locations en toute simplicité.</p>
            <a href="{{ config('app.url') }}" class="button">Accéder à mon espace</a>
            <p>À très bientôt,<br>L'équipe L'Fassia</p>
        </div>
        <div class="footer">
            &copy; {{ date('Y') }} L'Fassia - Maison de Haute Couture. Tous droits réservés.
        </div>
    </div>
</body>
</html>
