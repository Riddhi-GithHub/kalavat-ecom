<h1>Hello,{{$user->username}}</h1>

<p>
	please click the password reset button to reset your password

<a href="{{ route('change-password',['id' => $user['id']]) }}">Reset Password</a>
</p>

<p>Sending Mail from Kalavat</p>

<div style="text-align:center;padding:20px 0;width:700px;margin:auto;">
    <p style="font-size:14px;">Copyright @2021 <b>Kalavat</b> All Rights Reserved. We appreciate you!</p>
    <a style="margin:10px;color:#686363;text-decoration:none;font-weight:bold;" href="#" title="Facebook">support@kalavat.com</a>
</div>
