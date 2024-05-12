<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verifica Email</title>
</head>
<body>
    <h1>Ciao {{ $user_name }}</h1>
    Stai ricevendo questa email perché abbiamo ricevuto una richiesta di verifica della mail per il tuo account.

    <a href="{{ $url }}" target="_blank" >Verifica email</a>

    <p>
    <small>
        Se hai problemi a cliccare sul pulsante "Reimposta Password", copia e incolla l'URL qui sotto nel tuo browser web: {{ $url }}
        </small>
    </p>
</body>
</html>
