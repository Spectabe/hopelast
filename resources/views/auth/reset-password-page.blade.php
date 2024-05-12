<form id="password-reset-form">
    @csrf

    <input type="hidden" name="email" value="{{ $email }}" required>
    <input type="hidden" name="token" value="{{ $token }}" required>

    <div>
        <label for="password_confirmation">Password</label>
        <input type="password" name="password" id="password" required>
        <label for="password_confirmation">Conferma password</label>
        <input type="password" name="password_confirmation" id="password_confirmation" required>
    </div>

    <button type="submit">Reset password</button>
</form>

<div id="response-message"></div>

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
                if (data.status === 'success') {
                    document.getElementById('response-message').innerHTML =
                        '<div">' + data.message + '</div>';
                } else {
                    document.getElementById('response-message').innerHTML =
                        '<div">' + data.message + '</div>';
                }
            })
            .catch(error => {
                document.getElementById('response-message').innerHTML = '<div>' + error.message + '</div>';
            });
    });
</script>
