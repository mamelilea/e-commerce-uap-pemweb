/**
 * Wishlist functionality - global
 */

window.toggleWishlist = function(productId, buttonElement) {
    fetch('/wishlist/toggle', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        body: JSON.stringify({
            product_id: productId
        })
    })
    .then(response => {
        if (response.ok) {
            return response.json();
        }
        if (response.status === 401) {
            window.location.href = '/login';
            throw new Error('Unauthorized');
        }
        throw new Error('Network response was not ok');
    })
    .then(data => {
        if (data && data.success) {
            showToast(data.message, 'success');

            // Toggle visual state without reload
            if (buttonElement) {
                const svg = buttonElement.querySelector('svg');
                if (svg) {
                    if (data.in_wishlist) {
                        svg.classList.remove('text-gray-600');
                        svg.classList.add('fill-red-500', 'text-red-500');
                    } else {
                        svg.classList.remove('fill-red-500', 'text-red-500');
                        svg.classList.add('text-gray-600');
                        
                        // If we are on the wishlist page, remove the card
                        if (window.location.pathname.includes('/wishlist')) {
                            const card = buttonElement.closest('.group'); // Assuming card has .group class
                            if (card) {
                                card.remove();
                                // Optional: check if grid is empty and show empty state
                                const grid = document.querySelector('.grid');
                                // Check if grid is empty (taking into account text/comment nodes)
                                if (grid && grid.querySelectorAll('.group').length === 0) {
                                    location.reload(); 
                                }
                            }
                        }
                    }
                }
            } else {
                // Should not happen if passed correctly, but fallback
                 setTimeout(() => location.reload(), 800);
            }
        }
    })
    .catch(error => {
        if (error.message !== 'Unauthorized') {
             console.error('Wishlist toggle error:', error);
             showToast('Silahkan login terlebih dahulu', 'error');
             setTimeout(() => window.location.href = '/login', 1500);
        }
    });
}

window.showToast = function(message, type = 'success') {
    const toast = document.createElement('div');
    toast.className = `px-6 py-4 rounded-lg shadow-lg animate-slide-up fixed bottom-4 right-4 z-50 ${
        type === 'success' ? 'bg-gray-800' : 'bg-red-500'
    } text-white font-medium text-sm`;
    toast.textContent = message;
    document.body.appendChild(toast);
    setTimeout(() => toast.remove(), 3000);
}
