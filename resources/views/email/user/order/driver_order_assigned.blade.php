@include('email.header')
<a href="#" style="padding: 40px 0 15px;display: block;"><img src="{{ asset('/assets/images/logo/logo.png') }}" style="margin:0px 15px;height:50px" align="center" class="CToWUd"></a>
<h1 style="text-align:center;padding:0px 20px;font-size: 28px;font-weight: 700;margin: 0;">Hi, {{ $data['email'] }}!</h1>
<p style="text-align:center;padding:5px 20px;max-width: 480px;font-weight: 500;color: #636363;font-size: 15px;margin: 20px 0;">This Order has been assigned to you.</p>
@include('email.footer')
