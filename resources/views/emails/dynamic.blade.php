<!DOCTYPE html>
<html>

<head>
    <title>Email</title>
</head>

<body>
    Dear {{ $notifiable->name ?? 'User' }},<br>
    <br>
    {!! $body !!} <br>
    Regards, <br>
    {{ config('app.name') }}
</body>

</html>
