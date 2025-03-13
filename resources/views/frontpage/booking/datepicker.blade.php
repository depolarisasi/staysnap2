<input type="text" id="datepicker" data-room-id="{{ $room->id }}">

<script>
  flatpickr("#datepicker", {
    mode: "range",
    minDate: "today",
    onReady: (dates, dateStr, instance) => {
      // Ambil harga dari API endpoint
      fetch(`/api/room-prices/${roomId}`)
        .then(res => res.json())
        .then(prices => {
          instance.config.onDayCreate = (d) => {
            const dateStr = d.date.toISOString().split('T')[0];
            d.$innerHTML += `<div class="price-label">IDR ${prices[dateStr] ?? basePrice}</div>`;
          };
        });
    }
  });
</script>