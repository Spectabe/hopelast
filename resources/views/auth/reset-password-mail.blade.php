<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verifica Email</title>
</head>
<body>
    <h1>Ciao {{ $user_name }}</h1>
    
    <p>
    Stai ricevendo questa email perché abbiamo ricevuto una richiesta di reimpostazione della password per il tuo account.
    </p>

    <a href="{{ $url }}" target="_blank" >Reimposta password</a>
    
    <p>
    Questo link per reimpostare la password scadrà tra 60 minuti.
    Se non hai richiesto di reimpostare la tua password, non è richiesta alcuna altra azione.
    </p>

    <p>
    Saluti, il Team Daily
    </p>

    <p>
    <small>
        Se hai problemi a cliccare sul pulsante "Reimposta Password", copia e incolla l'URL qui sotto nel tuo browser web: {{ $url }}
    </small>
    </p>
</body>
</html>
