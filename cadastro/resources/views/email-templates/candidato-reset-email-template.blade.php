<p>Dear {{ $candidato->name }}</p>
<br>
<p>
    Your password on system was changed successfully.
    Here is your new login credentials:
    <br>
    <b>Login ID: </b>{{ $candidato->username }} or {{ $candidato->email }}
    <br>
    <b>Password: </b> {{ $new_password }}
</p>
<br>
Please, keep your credentials confidential. Your username and password are your own credentials and you should
never share them with anybody else.
