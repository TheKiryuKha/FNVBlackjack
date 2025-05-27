<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
</head>
<body>
    <form action="{{ route('login') }}" method="post">
        @csrf
        @method('post')
        <label>Email</label>
        @error('email')
            <p>{{ $message }}</p>
        @enderror
        <input type="text" name="email" value="{{ old('email') }}"><br>
        <label>Password</label>
        @error('password')
            <p>{{ $message }}</p>
        @enderror
        <input type="password" name="password"><br>

        <input type="submit" value="Авторизаия">
    </form>
</body>
</html>