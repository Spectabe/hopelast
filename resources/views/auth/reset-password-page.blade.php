<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cambia password</title>
    <link rel="stylesheet" href="{{ asset('css/style2.css') }}">
</head>

<body>
<form id="password-reset-form">
    @csrf

    <input type="hidden" name="email" value="{{ $email }}" required>
    <input type="hidden" name="token" value="{{ $token }}" required>

        <label for="password_confirmation">Password</label>
        <input type="password" name="password" id="password" required>
        <label for="password_confirmation">Conferma password</label>
        <input type="password" name="password_confirmation" id="password_confirmation" required>

    <button type="submit">Reset password</button>
    <div class="center">
            <small>Problemi? contattaci: hopelast532</small>
        </div>
<div id="response-message"></div>
</form>


</body>
<script>
    document.getElementById('password-reset-form').addEventListener('submit', function(e) {
        e.preventDefault();

        const formData = new FormData(this);

        fetch('{{ route('password.update') }}', {
                method: 'POST',
                body: formData
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error('Network response was not ok');
                }
                return response.json();
            })
            .then(data => {
                if (data.status === 'success')
                    document.getElementById('response-message').innerHTML =
                        '<div">' + data.message + '</div>';
            })
            .catch(error => {
                document.getElementById('response-message').innerHTML = '<div>' + error.message + '</div>';
            });
    });
</script>
</html>