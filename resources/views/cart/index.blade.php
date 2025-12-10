@extends('layouts.customer')

@section('title', 'Shopping Cart')

@section('content')
<div class="container mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <h1 class="text-3xl font-bold mb-8">Shopping Cart</h1>

    @if(empty($cart) || count($cart) === 0)
        <!-- Empty Cart State -->
        <div class="text-center py-16">
            <svg class="w-24 h-24 mx-auto text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/>
            </svg>
            <h2 class="text-2xl font-semibold text-gray-900 mb-2">Your cart is empty</h2>
            <p class="text-gray-600 mb-6">Start shopping to add items to your cart.</p>
            <a href="{{ route('products.index') }}" class="btn-primary inline-block">
                Continue Shopping
            </a>
        </div>
    @else
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Cart Items -->
            <div class="lg:col-span-2 space-y-4">
                <!-- Select All -->
                <div class="flex items-center gap-3 p-4 bg-gray-50 rounded-lg border border-gray-200">
                    <input type="checkbox" id="selectAll" onchange="toggleSelectAll(this)" class="w-5 h-5 rounded border-gray-300 text-black focus:ring-black cursor-pointer">
                    <label for="selectAll" class="font-bold text-gray-900 cursor-pointer">Select All</label>
                    <span class="text-sm text-gray-600 ml-auto">(<span id="selected-count">0</span> selected)</span>
                </div>

                @foreach($cart as $productId => $item)
                    <div class="card p-6" id="cart-item-{{ $productId }}">
                        <div class="flex gap-6">
                            <!-- Checkbox -->
                            <div class="flex-shrink-0 pt-1">
                                <input type="checkbox" 
                                       class="product-checkbox w-5 h-5 rounded border-gray-300 text-black focus:ring-black cursor-pointer" 
                                       data-product-id="{{ $productId }}"
                                       data-price="{{ $item['price'] }}"
                                       data-quantity="{{ $item['quantity'] }}"
                                       onchange="updateSelection()">
                            </div>

                            <!-- Product Image -->
                            <a href="{{ route('products.show', $item['slug']) }}" class="flex-shrink-0">
                                <div class="w-24 h-24 bg-gray-100 rounded-lg overflow-hidden">
                                    @if($item['image'])
                                        <img src="{{ asset('storage/' . $item['image']) }}" 
                                             alt="{{ $item['name'] }}"
                                             class="w-full h-full object-cover">
                                    @else
                                        <div class="w-full h-full flex items-center justify-center">
                                            <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                            </svg>
                                        </div>
                                    @endif
                                </div>
                            </a>

                            <!-- Product Info -->
                            <div class="flex-1 min-w-0">
                                <a href="{{ route('products.show', $item['slug']) }}" class="block">
                                    <h3 class="font-semibold text-gray-900 mb-1 hover:text-primary-900 transition-colors">
                                        {{ $item['name'] }}
                                    </h3>
                                </a>
                                <p class="text-sm text-gray-500 mb-2">{{ $item['store_name'] }}</p>
                                <p class="text-lg font-bold text-primary-900">
                                    Rp {{ number_format($item['price'], 0, ',', '.') }}
                                </p>
                            </div>

                            <!-- Quantity & Actions -->
                            <div class="flex flex-col items-end justify-between">
                                <!-- Quantity Adjuster -->
                                <div class="flex items-center border border-gray-300 rounded-lg">
                                    <button 
                                        type="button" 
                                        onclick="updateCart({{ $productId }}, {{ $item['quantity'] - 1 }})"
                                        class="px-3 py-1 hover:bg-gray-50 transition-colors">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4"/>
                                        </svg>
                                    </button>
                                    
                                    <span class="w-12 text-center font-medium" id="qty-{{ $productId }}">{{ $item['quantity'] }}</span>
                                    
                                    <button 
                                        type="button" 
                                        onclick="updateCart({{ $productId }}, {{ $item['quantity'] + 1 }})"
                                        class="px-3 py-1 hover:bg-gray-50 transition-colors">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                                        </svg>
                                    </button>
                                </div>

                                <!-- Remove Button -->
                                <button type="button" onclick="removeFromCart({{ $productId }})" class="text-sm text-red-600 hover:text-red-700 transition-colors">
                                    Remove
                                </button>

                                <!-- Subtotal -->
                                <p class="text-sm text-gray-600 mt-2">
                                    Subtotal: <span class="font-semibold" id="subtotal-{{ $productId }}">Rp {{ number_format($item['price'] * $item['quantity'], 0, ',', '.') }}</span>
                                </p>
                            </div>
                        </div>
                    </div>
                @endforeach

                <!-- Clear Cart -->
                <form action="{{ route('cart.clear') }}" method="POST" class="mt-4">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="text-sm text-red-600 hover:text-red-700 transition-colors">
                        Clear All Items
                    </button>
                </form>
            </div>

            <!-- Order Summary -->
            <div class="lg:col-span-1">
                <div class="card p-6 sticky top-24">
                    <h2 class="text-xl font-bold mb-6">Order Summary</h2>
                    
                    <div class="space-y-4 mb-6">
                        <div class="flex justify-between text-gray-600">
                            <span>Subtotal (<span id="total-items">{{ array_sum(array_column($cart, 'quantity')) }}</span> items)</span>
                            <span class="font-medium" id="summary-subtotal">Rp {{ number_format($total, 0, ',', '.') }}</span>
                        </div>
                        
                        <div class="flex justify-between text-sm text-primary-600">
                            <span>Selected (<span id="selected-items-count">0</span> items)</span>
                            <span class="font-semibold" id="selected-total">Rp 0</span>
                        </div>
                        
                        <div class="border-t border-gray-200 pt-4">
                            <div class="flex justify-between text-lg font-bold">
                                <span>Total to Pay</span>
                                <span class="text-primary-900" id="summary-total">Rp 0</span>
                            </div>
                        </div>
                    </div>

                    @auth
                        <button onclick="proceedToCheckout()" id="checkoutBtn" disabled class="block w-full btn-primary text-center mb-3 disabled:bg-gray-300 disabled:cursor-not-allowed">
                            Proceed to Checkout (<span id="checkout-count">0</span>)
                        </button>
                    @else
                        <a href="{{ route('login') }}" class="block w-full btn-primary text-center mb-3">
                            Login to Checkout
                        </a>
                    @endauth

                    <a href="{{ route('products.index') }}" class="block w-full btn-secondary text-center">
                        Continue Shopping
                    </a>
                </div>
            </div>
        </div>

<script>
// Toggle Select All
function toggleSelectAll(checkbox) {
    const productCheckboxes = document.querySelectorAll('.product-checkbox');
    productCheckboxes.forEach(cb => cb.checked = checkbox.checked);
    updateSelection();
}

// Update Selection and Totals
function updateSelection() {
    const checkboxes = document.querySelectorAll('.product-checkbox');
    const selectAllCheckbox = document.getElementById('selectAll');
    let selectedCount = 0;
    let selectedTotal = 0;
    let selectedItemsCount = 0;
    
    const selectedProducts = [];
    
    checkboxes.forEach(checkbox => {
        if (checkbox.checked) {
            selectedCount++;
            const price = parseInt(checkbox.dataset.price);
            const quantity = parseInt(checkbox.dataset.quantity);
            selectedTotal += price * quantity;
            selectedItemsCount += quantity;
            selectedProducts.push(checkbox.dataset.productId);
        }
    });
    
    // Update UI
    document.getElementById('selected-count').textContent = selectedCount;
    document.getElementById('selected-items-count').textContent = selectedItemsCount;
    document.getElementById('selected-total').textContent = 'Rp ' + selectedTotal.toLocaleString('id-ID');
    document.getElementById('summary-total').textContent = 'Rp ' + selectedTotal.toLocaleString('id-ID');
    document.getElementById('checkout-count').textContent = selectedCount;
    
    // Update Select All checkbox state
    selectAllCheckbox.checked = selectedCount === checkboxes.length && selectedCount > 0;
    selectAllCheckbox.indeterminate = selectedCount > 0 && selectedCount < checkboxes.length;
    
    // Enable/Disable checkout button
    const checkoutBtn = document.getElementById('checkoutBtn');
    if (checkoutBtn) {
        checkoutBtn.disabled = selectedCount === 0;
    }
    
    // Store selected products in session storage
    sessionStorage.setItem('selectedProducts', JSON.stringify(selectedProducts));
}

// Proceed to Checkout with Selected Items
function proceedToCheckout() {
    const selectedProducts = JSON.parse(sessionStorage.getItem('selectedProducts') || '[]');
    
    if (selectedProducts.length === 0) {
        alert('Please select at least one product to checkout');
        return;
    }
    
    // Redirect to checkout with selected products
    const params = new URLSearchParams();
    selectedProducts.forEach(id => params.append('products[]', id));
    window.location.href = `/checkout?${params.toString()}`;
}

function updateCart(productId, newQuantity) {
    if (newQuantity < 0) return; 

    fetch(`/cart/${productId}`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}',
            'Accept': 'application/json',
            'X-Requested-With': 'XMLHttpRequest',
            'X-HTTP-Method-Override': 'PATCH'
        },
        body: JSON.stringify({
            quantity: newQuantity
        })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            if (newQuantity <= 0 || data.message === 'Product removed from cart') {
                document.getElementById(`cart-item-${productId}`).remove();
                if (data.is_empty) location.reload();
            } else {
                document.getElementById(`qty-${productId}`).textContent = data.quantity;
                document.getElementById(`subtotal-${productId}`).textContent = 'Rp ' + data.item_subtotal;
                
                const btnMinus = document.querySelector(`#cart-item-${productId} button[onclick^="updateCart(${productId},"]`);
                const btnPlus = document.querySelectorAll(`#cart-item-${productId} button[onclick^="updateCart(${productId},"]`)[1];
                
                btnMinus.setAttribute('onclick', `updateCart(${productId}, ${data.quantity - 1})`);
                btnPlus.setAttribute('onclick', `updateCart(${productId}, ${data.quantity + 1})`);
            }
            
            document.getElementById('summary-subtotal').textContent = 'Rp ' + data.total;
            document.getElementById('summary-total').textContent = 'Rp ' + data.total;
            document.getElementById('total-items').textContent = data.cart_count;
            
            const navCount = document.getElementById('cartCount');
            if(navCount) {
                navCount.textContent = data.cart_count;
                navCount.classList.remove('hidden');
                if(data.cart_count === 0) navCount.classList.add('hidden');
            }

        } else {
            alert(data.message);
        }
    })
    .catch(error => {
        console.error('Error:', error);
    });
}

function removeFromCart(productId) {
    if(!confirm('Are you sure you want to remove this item?')) return;

    fetch(`/cart/${productId}`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}',
            'Accept': 'application/json',
            'X-Requested-With': 'XMLHttpRequest',
            'X-HTTP-Method-Override': 'DELETE'
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            document.getElementById(`cart-item-${productId}`).remove();
            
            document.getElementById('summary-subtotal').textContent = 'Rp ' + data.total;
            document.getElementById('summary-total').textContent = 'Rp ' + data.total;
            document.getElementById('total-items').textContent = data.cart_count;
            
            const navCount = document.getElementById('cartCount');
            if(navCount) {
                navCount.textContent = data.cart_count;
                navCount.classList.remove('hidden');
                if(data.cart_count === 0) navCount.classList.add('hidden');
            }

            if (data.is_empty) location.reload();
        }
    });
}
</script>
    @endif
</div>
@endsection
