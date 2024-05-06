@component('mail::message')
<h2>Xin chào!</h2>
<p>Chúng tôi xin gửi đến bạn một bước quan trọng để đảm bảo an toàn cho tài khoản của bạn tại BookStore.<br>
    Hãy chọn <b>Kích hoạt tài khoản</b> để tiếp tục.</p>
<div class="container">
    <button class="button-success"><a href="{{ url('/api/auth/verify', $token) }}">Kích hoạt tài khoản</a></button>
</div>
<p>Liên kết sẽ hết hạn sau 1 giờ.<br>Xin cảm ơn,<br>{{ config('app.name') }}</p>
@endcomponent