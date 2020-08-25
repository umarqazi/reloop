@include('email.header')
<h1 style="text-align:center;padding:0px 20px;font-size: 28px;font-weight: 700;margin: 0;">Hi, {{ $data['email'] }}!</h1>
<p style="text-align:center;padding:5px 20px;max-width: 480px;font-weight: 500;color: #636363;font-size: 15px;margin: 20px 0;">You've requested for a new password.</p>
<a href="{{ $data['resetUrl'] }}" style="text-decoration: none;color: #ffffff; background-color: #B2CE40;padding: 10px 50px;border-radius:30px;margin:20px 0;font-weight: 700;">Click here to reset your password.</a>
@include('email.footer')
