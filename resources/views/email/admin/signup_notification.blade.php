@include('email.header')
<h1 style="text-align:center;padding:0px 20px;font-size: 28px;font-weight: 700;margin: 0;">Hi, Admin!</h1>
<p style="text-align:center;padding:5px 20px;max-width: 480px;font-weight: 500;color: #636363;font-size: 15px;margin: 20px 0;">This {{ $data->email }} user has registered on ReLoop.</p>
@include('email.footer')
