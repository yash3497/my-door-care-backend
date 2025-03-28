<form action="{{ route('subscribe') }}" method="POST">
    @csrf
    <input type="text" name="email" class="form--control" placeholder="Email Address">
    <button type="submit"><i class="fab fa-telegram-plane"></i></button>
</form>
