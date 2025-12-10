@extends('layouts.customer')

@section('title', 'Shop - All Products')

@section('content')
{{-- Page Header --}}
<div class="bg-gray-50 py-8 border-b border-gray-200">
    <div class="container-custom">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-bold" style="color: #252B42;">Shop</h1>
                <p class="text-sm text-gray-600">Showing all {{ $products->total() }} results</p>
            </div>
            <nav class="text-sm text-gray-600">
                <a href="{{ route('home') }}" class="hover:text-primary-500">Home</a> / 
                <span class="font-bold">Shop</span>
            </nav>
        </div>
    </div>
</div>

<div class="container-custom py-8">
    <div class="grid grid-cols-1 lg:grid-cols-4 gap-8">
        {{-- Sidebar Filters --}}
        <aside class="space-y-6">
            {{-- Categories --}}
            <div class="bg-white rounded-lg border border-gray-200 p-6">
                <h3 class="font-bold mb-4" style="color: #252B42;">Categories</h3>
                <div class="space-y-2">
                    <a href="{{ route('products.index') }}" 
                       class="block py-2 text-sm {{ !request('category') ? 'text-primary-500 font-bold' : 'text-gray-600 hover:text-primary-500' }}">
                        All Products
                    </a>
                    @foreach($categories->whereNull('parent_id') as $parent)
                        <div class="mb-3">
                            <p class="font-bold text-sm text-gray-800 mb-2">{{ $parent->name }}</p>
                            @foreach($parent->children as $child)
                                <a href="{{ route('products.index', ['category' => $child->id]) }}" 
                                   class="block py-1 pl-4 text-sm {{ request('category') == $child->id ? 'text-primary-500 font-bold' : 'text-gray-600 hover:text-primary-500' }}">
                                    {{ $child->name }} 
                                    @if($child->products_count > 0)
                                        <span class="text-xs text-gray-400">({{ $child->products_count }})</span>
                                    @endif
                                </a>
                            @endforeach
                        </div>
                    @endforeach
                </div>
            </div>

            {{-- Price Filter --}}
            <div class="bg-white rounded-lg border border-gray-200 p-6">
                <h3 class="font-bold mb-4" style="color: #252B42;">Filter by Price</h3>
                <form id="priceFilterForm" action="{{ route('products.index') }}" method="GET">
                    {{-- Preserve other query parameters --}}
                    <input type="hidden" name="category" value="{{ request('category') }}">
                    <input type="hidden" name="search" value="{{ request('search') }}">
                    <input type="hidden" name="sort" value="{{ request('sort') }}">
                    
                    <div class="space-y-3">
                        @php
                            $selectedRanges = request('price_ranges', []);
                            if (!is_array($selectedRanges)) {
                                $selectedRanges = [$selectedRanges];
                            }
                            
                            $priceRanges = [
                                ['value' => '0-200000', 'label' => 'Rp 0 - Rp 200.000'],
                                ['value' => '200000-500000', 'label' => 'Rp 200.000 - Rp 500.000'],
                                ['value' => '500000-1000000', 'label' => 'Rp 500.000 - Rp 1.000.000'],
                                ['value' => '1000000-0', 'label' => 'Rp 1.000.000 - Rp 5.000.000'],
                            ];
                        @endphp
                        
                        {{-- Clear all filters option --}}
                        <div class="pb-2 border-b border-gray-200">
                            <a href="{{ route('products.index', request()->except(['price_ranges', 'min_price', 'max_price'])) }}" 
                               class="text-sm {{ empty($selectedRanges[0]) ? 'text-primary-500 font-bold' : 'text-gray-600 hover:text-primary-500' }}">
                                All Prices
                            </a>
                        </div>
                        
                        {{-- Checkbox filters --}}
                        @foreach($priceRanges as $range)
                            <label class="flex items-center space-x-3 cursor-pointer hover:bg-gray-50 p-2 rounded transition-colors">
                                <input 
                                    type="checkbox" 
                                    name="price_ranges[]" 
                                    value="{{ $range['value'] }}"
                                    {{ in_array($range['value'], $selectedRanges) ? 'checked' : '' }}
                                    onchange="document.getElementById('priceFilterForm').submit()"
                                    class="w-4 h-4 text-primary-500 border-gray-300 rounded focus:ring-primary-500 focus:ring-2 cursor-pointer"
                                >
                                <span class="text-sm text-gray-700">{{ $range['label'] }}</span>
                            </label>
                        @endforeach
                    </div>
                </form>
            </div>
        </aside>

        {{-- Products Grid --}}
        <div class="lg:col-span-3">
            <div id="productGridContainer">
                @include('components.product-grid', ['products' => $products])
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    // Debounce function
    function debounce(func, wait) {
        let timeout;
        return function(...args) {
            clearTimeout(timeout);
            timeout = setTimeout(() => func.apply(this, args), wait);
        };
    }

    function filterProducts(url = null) {
        const form = document.getElementById('priceFilterForm');
        const formData = new FormData(form);
        
        // Add sort to formData
        const sortSelect = document.querySelector('select[name="sort"]');
        if (sortSelect) {
            formData.append('sort', sortSelect.value);
        }

        // Build Query String
        const params = new URLSearchParams(formData);
        
        // If specific URL provided (pagination), use allowed params from it or merge
        let fetchUrl = url || `{{ route('products.index') }}?${params.toString()}`;

        // Parse params from the actual URL we are fetching to ensure we have the latest category
        const fetchUrlObj = new URL(fetchUrl, window.location.origin);
        const newParams = fetchUrlObj.searchParams;
        const activeCategory = newParams.get('category');

        // Update hidden category input so subsequent form submissions (price/sort) use the new category
        const categoryInput = document.querySelector('input[name="category"]');
        if (categoryInput) {
            categoryInput.value = activeCategory || '';
        }

        // Show loading state
        document.getElementById('productGridContainer').style.opacity = '0.5';

        fetch(fetchUrl, {
            headers: {
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
        .then(response => response.text())
        .then(html => {
            document.getElementById('productGridContainer').innerHTML = html;
            document.getElementById('productGridContainer').style.opacity = '1';
            
            // Update URL
            window.history.pushState({}, '', fetchUrl);

            // Update Sidebar Active State
            updateSidebarActiveState(activeCategory);
        })
        .catch(error => {
            console.error('Error:', error);
            document.getElementById('productGridContainer').style.opacity = '1';
        });
    }

    function updateSidebarActiveState(activeCategoryId) {
        const sidebar = document.querySelector('aside');
        if (!sidebar) return;

        const links = sidebar.querySelectorAll('a');
        links.forEach(link => {
            const url = new URL(link.href, window.location.origin);
            const linkCategoryId = url.searchParams.get('category');
            
            // Determine if this is the active link
            // "All Products" usually has no category param
            const isActive = (activeCategoryId && linkCategoryId === activeCategoryId) || 
                             (!activeCategoryId && !linkCategoryId && link.pathname === '{{ route("products.index", [], false) }}' && !link.search);

            if (isActive) {
                link.classList.remove('text-gray-600', 'hover:text-primary-500');
                link.classList.add('text-primary-500', 'font-bold');
            } else {
                link.classList.remove('text-primary-500', 'font-bold');
                link.classList.add('text-gray-600', 'hover:text-primary-500');
            }
        });
    }

    // Attach listeners
    document.addEventListener('DOMContentLoaded', () => {
        // Event Delegation for Sort Select
        document.getElementById('productGridContainer').addEventListener('change', (e) => {
            if (e.target.name === 'sort') {
                filterProducts();
            }
        });

        // Price checkboxes
        const priceCheckboxes = document.querySelectorAll('input[name="price_ranges[]"]');
        priceCheckboxes.forEach(cb => {
            cb.removeAttribute('onchange');
            cb.addEventListener('change', () => filterProducts());
        });

        // Sidebar links interception (Categories, All Prices)
        const sidebar = document.querySelector('aside');
        if (sidebar) {
            sidebar.addEventListener('click', (e) => {
                const link = e.target.closest('a');
                if (link && link.href && !link.hasAttribute('target')) {
                    e.preventDefault();
                    filterProducts(link.href);
                    // Optional: Scroll to top
                    document.getElementById('productGridContainer').scrollIntoView({ behavior: 'smooth' });
                }
            });
        }

        // Pagination links interception
        document.getElementById('productGridContainer').addEventListener('click', (e) => {
            if (e.target.tagName === 'A' || e.target.closest('a')) {
                const link = e.target.tagName === 'A' ? e.target : e.target.closest('a');
                if (link && link.href && link.href.includes('page=')) {
                    e.preventDefault();
                    filterProducts(link.href);
                    document.getElementById('productGridContainer').scrollIntoView({ behavior: 'smooth' });
                }
            }
        });
    });
</script>
@endpush
@endsection
