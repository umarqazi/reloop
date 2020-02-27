<div style="background: #e1e1e1;padding: 50px 0;">
    <table border="0" align="center" cellpadding="0" cellspacing="0" width="650" style="transform: translate(-50%, -50%);position: absolute;top: 50%;left: 50%;">
        <tbody>
        <tr>
            <td style="background-color:#ffffff;padding:5px 10px;font-family:'poppins';font-size:14px;color:#333;line-height:25px;border: 1px solid transparent;" align="center">
                <a href="#" style="padding: 40px 0 15px;display: block;"><img src="logo.png" style="margin:0px 15px;height:50px" align="center" class="CToWUd"></a>
                <h1 style="text-align:center;padding:0px 20px;font-size: 28px;font-weight: 700;margin: 0;">Hi, {{ $data->email }}!</h1>
                <p style="text-align:center;padding:5px 20px;max-width: 480px;font-weight: 500;color: #636363;font-size: 15px;margin: 20px 0;">Thanks for creating an account with us.To continue, please confirm your email address by clicking the button below.</p>
                <a href="{{ url(env('APP_URL').'/activate-account/'.$data->id.'/'.$data->signup_token) }}" style="text-decoration: none;color: #ffffff; background-color: #B2CE40;padding: 10px 50px;border-radius:30px;margin:20px 0;font-weight: 700;">Verify Your Email</a>
                <p style="text-align:center;padding:20px 20px;max-width: 480px;font-weight: 500;color: #636363;font-size: 15px;margin:0;">Or if you wish,you can verify this link:</p>
                <a href="#" style="text-decoration: none;color: #4292D8;padding:0 0 60px;margin:0;font-weight: 500;font-size:15px;display: block;">{{ url(env('APP_URL').'/activate-account/'.$data->id.'/'.$data->signup_token) }}</a>
                <p style="text-align:center;padding:0 20px 20px;max-width: 400px;font-weight:700;color:#636363; margin: 0;">Stay in Touch.</p>
                <a href="#" target="_blank" style="display: inline-block;background-color: #B2CE40;padding: 5px 7px; border-radius: 50%;color: white;margin-bottom: 60px;"><i class="fa fa-facebook"style="font-size: 16px;"></i></a>
                <a href="#" target="_blank" style="display: inline-block;background-color: #B2CE40;padding: 5px 7px; border-radius: 50%;color: white;margin-bottom: 60px;"><i class="fa fa-twitter" style="font-size: 16px;"></i></a>
            </td>
        </tr>
        </tbody>
    </table>
</div>
