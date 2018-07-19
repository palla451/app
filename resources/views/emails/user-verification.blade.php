<!DOCTYPE html>
<html lang="en-US">
<head>
    <meta charset="utf-8">
</head>
<body>
<div>
    <p>Benvenuto {{ $user->name }}</p>

    <p>Grazie per esserti registrato al sistema di Booking online di Pickcenter</p>

    <p>Per confermare la tua registrazione e continuare con il tuo account clicck sul seguente link: <br/>
    <a href="{{ url('activate/' . $token) }}">{{ url('activate/' . $token) }}</a>
    </p>

    <p>Solo dopo la conferma potrai entrare con le tue credenziali.</p>

    <p>Grazie.</p>

    <p>Pickcenter</p>
</div>

</body>
</html>