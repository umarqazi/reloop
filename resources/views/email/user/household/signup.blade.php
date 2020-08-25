@include('email.header')
<h1 style="text-align:center;padding:0px 20px;font-size: 28px;font-weight: 700;margin: 0;">Hi ReLooper!</h1>
<p style="text-align:center;padding:5px 20px;max-width: 480px;font-weight: 500;color: #636363;font-size: 15px;margin: 20px 0;">Thanks for creating an account with us. To continue, please confirm your email address by clicking the button below.</p>
<a href="{{ url(env('APP_URL').'/activate-account/'.$data->id.'/'.$data->signup_token) }}" style="text-decoration: none;color: #ffffff; background-color: #B2CE40;padding: 10px 50px;border-radius:30px;margin:20px 0;font-weight: 700;">Verify Your Email</a>
<p style="text-align:center;padding:20px 20px;max-width: 480px;font-weight: 500;color: #636363;font-size: 15px;margin:0;">Or if you wish, you can verify this link:</p>
<a href="{{ url(env('APP_URL').'/activate-account/'.$data->id.'/'.$data->signup_token) }}" style="text-decoration: none;color: #4292D8;padding:0 0 60px;margin:0;font-weight: 500;font-size:15px;display: block;">{{ url(env('APP_URL').'/activate-account/'.$data->id.'/'.$data->signup_token) }}</a>
@include('email.footer')
