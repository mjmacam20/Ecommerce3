<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title></title>
</head>
<body>
    <table>
        <tr><td>Dear {{ $name }}</td></tr>
        <tr><td>&nbsp;</td></tr>
        <tr><td>You Requested a new password. Please check below:-:</td></tr>
        <tr><td>&nbsp;</td></tr>
        <tr><td>Email: {{ $email }}</td></tr>
        <tr><td>&nbsp;</td></tr>
        <tr><td>Password: {{ $password }}</td></tr>
        <tr><td>&nbsp;</td></tr>
        <tr><td>Sincerly,</td></tr>
        <tr><td>Wavepad Management</td></tr>
    </table>
    
</body>
</html>