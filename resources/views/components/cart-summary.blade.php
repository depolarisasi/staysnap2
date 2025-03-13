@foreach(session('cart.items') as $item)
<div class="cart-item">
  <h4>{{ $item['room']->name }}</h4>
  <p>{{ $item['check_in'] }} - {{ $item['check_out'] }}</p>
  <p>Total: IDR {{ number_format($item['total']) }}</p>
</div>
@endforeach