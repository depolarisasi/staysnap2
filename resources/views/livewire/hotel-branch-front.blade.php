<div> 
    <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
        @foreach($branches as $branch)
        <a href="#" 
           class="block bg-white rounded-lg shadow-md overflow-hidden 
                  transform transition-all duration-300 
                  hover:-translate-y-2 hover:shadow-lg">
            <div class="h-48 bg-gray-200 flex items-center justify-center">
                <img src="{{ asset('storage/'.$branch->branch_thumbnail) }}" 
                     class="h-full w-full object-cover" />
            </div>
            <div class="p-6">
                <h3 class="text-xl font-semibold mb-2">{{ $branch->branch_name }}</h3>
                <p class="text-gray-600 mb-4">Lorem ipsum...</p>
                <div class="text-indigo-600 hover:text-indigo-800 font-medium">
                    View Details →
                </div>
            </div>
        </a>
    @endforeach 
    </div>
</div>
