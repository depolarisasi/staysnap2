<div>
    <div class="absolute inset-0 overflow-hidden" 
    x-data="carousel()" 
    x-init="init()" 
    @keydown.arrow-left="prev()" 
    @keydown.arrow-right="next()">
   <div class="relative h-full">
       <!-- Slides -->
       <div class="flex h-full transition-transform duration-300 ease-out"
            :style="`transform: translateX(-${currentSlide * 100}%)`">
           @foreach($slides as $slide)
           <div class="h-full w-full flex-shrink-0">
            <img src="{{ asset('storage/'. $slide['image'] )}}" 
                 class="h-full w-full object-cover"  >
        </div>
           @endforeach
       </div>

       <!-- Controls -->
       <button class="absolute top-1/2 left-4 transform -translate-y-1/2 bg-white/30 hover:bg-white/50 p-2 rounded-full transition-colors" 
               @click="prev()">
           ←
       </button>
       <button class="absolute top-1/2 right-4 transform -translate-y-1/2 bg-white/30 hover:bg-white/50 p-2 rounded-full transition-colors" 
               @click="next()">
           →
       </button>
 
   </div>
</div>

<script>
document.addEventListener('alpine:init', () => {
   Alpine.data('carousel', () => ({
       currentSlide: 0,
       totalSlides: @json(count($slides)), // Dynamic slide count
       autoPlayInterval: null,

       init() { 
           this.autoPlayInterval = setInterval(() => this.next(), 5000);
       },

       next() {
           this.currentSlide = (this.currentSlide + 1) % this.totalSlides;
       },

       prev() {
           this.currentSlide = (this.currentSlide - 1 + this.totalSlides) % this.totalSlides;
       },

       goTo(index) {
           this.currentSlide = index;
       },
       
       destroy() {
           if (this.autoPlayInterval) {
               clearInterval(this.autoPlayInterval);
           }
       }
   }));
});
</script>
</div>
