Welcome {{ $User->name }}

Please Visit the link below to verify your account.

<a href="{{ url('/verify', ['hash'=>$hash]) }}">Click Here to verify</a>

Thankyou.