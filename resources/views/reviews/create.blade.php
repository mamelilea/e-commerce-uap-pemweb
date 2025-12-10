<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Rate Products') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h3 class="text-lg font-bold mb-4">Order #{{ $transaction->code }}</h3>
                    
                    <div class="space-y-6">
                        @foreach($transaction->transactionDetails as $detail)
                            <div class="border rounded-lg p-4">
                                <div class="flex items-center gap-4 mb-4">
                                    <div class="w-16 h-16 bg-gray-200 rounded overflow-hidden">
                                        @if($detail->product->productImages->count() > 0)
                                            <img src="{{ asset('storage/' . $detail->product->productImages->first()->image) }}" class="w-full h-full object-cover">
                                        @endif
                                    </div>
                                    <div>
                                        <h4 class="font-bold">{{ $detail->product->name }}</h4>
                                        <p class="text-sm text-gray-500">Rp {{ number_format($detail->subtotal, 0, ',', '.') }}</p>
                                    </div>
                                </div>

                                @php
                                    $existingReview = \App\Models\Review::where('user_id', auth()->id())
                                        ->where('product_id', $detail->product_id)
                                        ->first();
                                @endphp

                                @if($existingReview)
                                    <div class="bg-gray-50 p-4 rounded">
                                        <p class="text-sm font-semibold text-green-600 mb-2">You rated this product:</p>
                                        <div class="flex items-center mb-1">
                                            @for($i=1; $i<=5; $i++)
                                                <svg class="w-5 h-5 {{ $i <= $existingReview->rating ? 'text-[#ff9900]' : 'text-gray-300' }} fill-current" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path d="M12 17.27L18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2 9.19 8.63 2 9.24l5.46 4.73L5.82 21z"/></svg>
                                            @endfor
                                        </div>
                                        <p class="text-gray-700 italic">"{{ $existingReview->comment }}"</p>
                                    </div>
                                @else
                                    <form action="{{ route('reviews.store') }}" method="POST">
                                        @csrf
                                        <input type="hidden" name="product_id" value="{{ $detail->product_id }}">
                                        
                                        <div class="mb-4">
                                            <label class="block text-gray-700 text-sm font-bold mb-2">Rating</label>
                                            <div class="flex items-center space-x-1" x-data="{ rating: 0, hover: 0 }">
                                                <input type="hidden" name="rating" :value="rating">
                                                <template x-for="i in 5">
                                                    <svg @click="rating = i" @mouseover="hover = i" @mouseleave="hover = 0"
                                                         class="w-8 h-8 cursor-pointer fill-current"
                                                         :class="(hover >= i || rating >= i) ? 'text-[#ff9900]' : 'text-gray-300'"
                                                         xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                                                        <path d="M12 17.27L18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2 9.19 8.63 2 9.24l5.46 4.73L5.82 21z"/>
                                                    </svg>
                                                </template>
                                            </div>
                                        </div>

                                        <div class="mb-4">
                                            <label class="block text-gray-700 text-sm font-bold mb-2">Review</label>
                                            <textarea name="comment" rows="3" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" placeholder="Write your review..."></textarea>
                                        </div>

                                        <button type="submit" class="bg-[#ff9900] hover:bg-orange-600 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                                            Submit Review
                                        </button>
                                    </form>
                                @endif
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
