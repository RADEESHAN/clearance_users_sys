<!DOCTYPE html>
<html>
<head>
    <title>Import Users</title>
</head>
<body>
    @if(session('success'))
        <div>{{ session('success') }}</div>
    @endif

    <form action="{{ route('users.import') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <input type="file" name="file" required>
        <button type="submit">Import Users</button>
    </form>
</body>
</html>