{{-- Toast Notification Component (Black & White) --}}
<div id="toastNotification" class="fixed top-4 right-4 z-50 transform translate-x-full transition-transform duration-300 ease-out">
    <div class="bg-black text-white px-6 py-4 rounded-lg shadow-2xl flex items-center gap-4 min-w-[320px]">
        {{-- Icon --}}
        <div class="flex-shrink-0">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
        </div>
        
        {{-- Content --}}
        <div class="flex-1">
            <p class="font-bold text-white" id="toastTitle">Product Added!</p>
            <p class="text-sm text-gray-300 mt-1" id="toastMessage">Successfully added to cart</p>
        </div>
        
        {{-- Close Button --}}
        <button onclick="hideToast()" class="flex-shrink-0 text-gray-400 hover:text-white transition-colors">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
            </svg>
        </button>
    </div>
</div>

<script>
function showCartNotification(quantity, totalItems) {
    const toast = document.getElementById('toastNotification');
    const title = document.getElementById('toastTitle');
    const message = document.getElementById('toastMessage');
    
    title.textContent = '✓ Added to Cart!';
    message.textContent = `${quantity} item${quantity > 1 ? 's' : ''} added • ${totalItems} total in cart`;
    
    // Show toast
    toast.classList.remove('translate-x-full');
    toast.classList.add('translate-x-0');
    
    // Auto hide after 3 seconds
    setTimeout(() => {
        hideToast();
    }, 3000);
}

function hideToast() {
    const toast = document.getElementById('toastNotification');
    toast.classList.remove('translate-x-0');
    toast.classList.add('translate-x-full');
}
</script>
