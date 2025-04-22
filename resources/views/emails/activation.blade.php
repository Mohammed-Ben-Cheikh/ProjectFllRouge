<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Activation de votre compte</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;600&family=Poppins:wght@300;400;500&display=swap');

        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f9f5f0;
            margin: 0;
            padding: 20px;
            color: #2c1810;
            line-height: 1.6;
        }

        .email-container {
            max-width: 600px;
            margin: 0 auto;
            background: white;
            border-radius: 20px;
            overflow: hidden;
            box-shadow: 0 15px 35px rgba(44, 24, 16, 0.1);
        }

        .header {
            background: linear-gradient(145deg, #8b6b45, #d4a76a);
            padding: 35px 20px;
            text-align: center;
            color: white;
        }

        .logo {
            font-family: 'Playfair Display', serif;
            font-size: 32px;
            font-weight: 600;
            margin-bottom: 15px;
            text-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }

        h1 {
            font-family: 'Playfair Display', serif;
            margin: 0;
            font-size: 26px;
            font-weight: 400;
            letter-spacing: 0.5px;
        }

        .content {
            padding: 40px;
        }

        p {
            line-height: 1.8;
            margin-bottom: 24px;
            font-size: 15px;
        }

        .activation-btn {
            display: inline-block;
            background: linear-gradient(145deg, #8b6b45, #d4a76a);
            color: white;
            text-decoration: none;
            padding: 16px 40px;
            border-radius: 50px;
            font-weight: 500;
            margin: 30px 0;
            transition: all 0.4s ease;
            box-shadow: 0 6px 18px rgba(139, 107, 69, 0.25);
            font-size: 16px;
        }

        .activation-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(139, 107, 69, 0.35);
        }

        .highlight-box {
            background-color: #fdfaf6;
            padding: 20px;
            border-left: 4px solid #8b6b45;
            border-radius: 0 12px 12px 0;
            margin: 30px 0;
            box-shadow: 0 3px 12px rgba(44, 24, 16, 0.06);
        }

        .footer {
            text-align: center;
            padding: 25px;
            background: #f7f3ee;
            color: #8b6b45;
            font-size: 14px;
            border-top: 1px solid rgba(139, 107, 69, 0.1);
        }

        .footer a {
            color: #8b6b45;
            text-decoration: underline;
            transition: color 0.3s ease;
        }

        .footer a:hover {
            color: #d4a76a;
        }

        @media (max-width: 600px) {
            body {
                padding: 10px;
            }
            .content {
                padding: 25px;
            }
        }
    </style>
</head>
<body>
    <div class="email-container">
        <div class="header">
            <div class="logo">RiadBookingNow</div>
            <h1>Bienvenue sur RiadBookingNow</h1>
        </div>

        <div class="content">
            <p>Cher(e) client(e),</p>

            <p>Nous vous souhaitons la bienvenue sur RiadBookingNow et vous remercions de votre confiance. Pour finaliser la création de votre compte et commencer à découvrir notre sélection exclusive de riads authentiques au Maroc, veuillez confirmer votre adresse email :</p>

            <div style="text-align: center;">
                <a href="{{ $activationUrl }}" class="activation-btn">Confirmer mon adresse email</a>
            </div>

            <div class="highlight-box">
                <p>Note importante : Ce lien de confirmation est valable pendant <strong>24 heures</strong>. Si le bouton ne fonctionne pas, veuillez copier et coller l'URL suivante dans votre navigateur :</p>
                <p style="word-break: break-all; font-size: 13px; color: #7a6a5a;">{{ $activationUrl }}</p>
            </div>

            <p>Pour votre sécurité, si vous n'avez pas initié cette demande de création de compte, veuillez ignorer cet email.</p>

            <p>Notre équipe reste à votre entière disposition pour vous accompagner dans la découverte de nos hébergements d'exception.</p>

            <p>Bien cordialement,<br>
            <strong>L'équipe RiadBookingNow</strong><br>
            <span style="font-size: 13px; color: #7a6a5a;">Votre partenaire de confiance pour des séjours authentiques au Maroc</span></p>
        </div>

        <div class="footer">
            <p>© {{ date('Y') }} RiadBookingNow. Tous droits réservés.</p>
            <p>Si vous avez des questions, contactez-nous à <a href="mailto:contact@riadbookingnow.com">contact@riadbookingnow.com</a></p>
        </div>
    </div>
</body>
</html>
