@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="flex h-full relative">
    {{-- Product Area --}}
    <div class="flex-1 p-6 overflow-y-auto">

        {{-- Category Tabs --}}
        <div class="flex gap-6 border-b border-stone-200 mb-6">
            @foreach(['food' => 'FOOD', 'drinks' => 'DRINKS', 'snacks' => 'SNACKS', 'dessert' => 'DESSERT'] as $key => $label)
            <a href="{{ route('pos.index', ['category' => $key]) }}"
                class="pb-3 text-sm font-semibold tracking-wider transition-colors relative
                        {{ $category === $key
                            ? 'text-[#1C1917] after:absolute after:bottom-0 after:left-0 after:right-0 after:h-0.5 after:bg-primary'
                            : 'text-[#78716C] hover:text-[#1C1917]' }}">
                {{ $label }}
            </a>
            @endforeach
        </div>

        {{-- Menu Header --}}
        <div class="flex items-center justify-between mb-5">
            <div class="flex items-center gap-3">
                <h2 class="text-xl font-bold text-[#1C1917]">Menu Items</h2>
                <span class="text-sm text-[#78716C] font-medium">({{ $products->count() }} Items)</span>
            </div>
            <div class="flex items-center gap-2">
            </div>
        </div>

        {{-- Product Grid --}}
        <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 xl:grid-cols-5 gap-4" id="product-grid">
            @forelse($products as $product)
            <div class="bg-white rounded-2xl overflow-hidden shadow-sm hover:shadow-md transition-all cursor-pointer group"
                data-product-id="{{ $product->id }}"
                data-product-name="{{ $product->name }}"
                data-product-price="{{ $product->price }}"
                data-product-image="{{ $product->image_url }}"
                data-product-stock="{{ $product->stock }}"
                onclick="cartModule.addToCart(this)">
                <div class="aspect-square overflow-hidden bg-stone-100">
                    <img src="{{ $product->image_url }}"
                        alt="{{ $product->name }}"
                        class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
                </div>
                <div class="p-3">
                    <h3 class="text-sm font-semibold text-[#1C1917] truncate">{{ $product->name }}</h3>
                    <div class="flex items-center justify-between mt-1">
                        <span class="text-sm font-bold text-primary">{{ $product->formatted_price }}</span>
                        <button class="w-6 h-6 flex items-center justify-center text-stone-400 hover:text-primary transition-colors">
                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <circle cx="12" cy="12" r="10"/><path stroke-linecap="round" d="M12 8v8M8 12h8"/>
                            </svg>
                        </button>
                    </div>
                </div>
            </div>
            @empty
            <div class="col-span-full text-center py-16 text-[#78716C]">
                <svg class="w-12 h-12 mx-auto mb-3 text-stone-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"/>
                </svg>
                <p>No products found.</p>
            </div>
            @endforelse
        </div>
    </div>
</div>

{{-- Draggable Order Panel --}}
<div id="order-panel"
    class="hidden fixed bg-white rounded-2xl shadow-xl w-80 z-30 overflow-hidden select-none"
    style="bottom: 24px; left: 280px; min-height: 200px;">

    {{-- Handle --}}
    <div id="order-panel-handle" class="flex items-center justify-between px-4 pt-4 pb-2 cursor-grab active:cursor-grabbing">
        <div class="flex items-center gap-2">
            <h3 class="font-bold text-[#1C1917] text-base">Your Order</h3>
            <span id="panel-item-count" class="text-xs font-bold bg-primary text-white px-2 py-0.5 rounded-full">0 ITEMS</span>
        </div>
        <button id="panel-close-btn" class="w-6 h-6 flex items-center justify-center text-stone-400 hover:text-red-400">
            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
            </svg>
        </button>
    </div>

    {{-- Items --}}
    <div id="order-items-list" class="px-4 py-2 space-y-3 max-h-52 overflow-y-auto">
        {{-- Populated by cartModule --}}
    </div>

    {{-- Footer --}}
    <div class="px-4 pt-3 pb-4 border-t border-stone-100 mt-2">
        <div class="flex items-center justify-between mb-3">
            <span class="text-sm font-semibold text-[#1C1917]">Total</span>
            <span id="panel-total" class="text-base font-bold text-primary">Rp0</span>
        </div>
        <button id="checkout-btn"
                onclick="checkoutModule.openCheckout()"
                class="w-full bg-primary hover:bg-[#EA580C] text-white font-semibold py-3 rounded-2xl transition-colors flex items-center justify-center gap-2 text-sm">
            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M3 3h2l.4 2M7 13h10l4-8H5.4m0 0L7 13m0 0l-2.5 5h15M17 21a1 1 0 100-2 1 1 0 000 2zM7 21a1 1 0 100-2 1 1 0 000 2z"/>
            </svg>
            Checkout
        </button>
    </div>
</div>

{{-- Checkout Modal --}}
@include('pos.partials.checkout-modal')

@endsection

@push('scripts')
<script src="{{ asset('js/modules/checkoutModule.js') }}"></script>
@endpush
