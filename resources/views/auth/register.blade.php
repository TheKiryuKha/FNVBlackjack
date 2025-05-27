<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
</head>
<body>
    <form action="/register" method="post">
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
        <label>Password Confirmation</label>
        @error('password_confirmation')
            <p>{{ $message }}</p>
        @enderror
        <input type="password" name="password_confirmation"><br>

        @if ($errors->any())
            @foreach ($errors->all() as $error)
                <p>{{ $error }}</p>
            @endforeach
        @endif

        <input type="submit" value="Зарегестрироваться">
    </form>
</body>
</html>