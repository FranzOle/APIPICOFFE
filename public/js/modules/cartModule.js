/**
 * cartModule.js
 * Handles all cart UI rendering by subscribing to cartStore.
 * Follows strict data-flow: UI → Store → notify() → re-render.
 */

const cartModule = (() => {

    // ── Add item from DOM ──────────────────────────────────────────────────────
    function addToCart(productEl) {
        const product = {
            product_id: parseInt(productEl.dataset.productId),
            name:       productEl.dataset.productName,
            price:      parseInt(productEl.dataset.productPrice),
            image:      productEl.dataset.productImage,
        };

        cartStore.addItem(product);
    }

    // ── Render cart panel ──────────────────────────────────────────────────────
    function render(state) {
        const panel    = document.getElementById('order-panel');
        const list     = document.getElementById('order-items-list');
        const countEl  = document.getElementById('panel-item-count');
        const totalEl  = document.getElementById('panel-total');
        const badge    = document.getElementById('cart-badge');

        if (!panel) return;

        const totalQty = state.items.reduce((acc, i) => acc + i.quantity, 0);

        // Show/hide panel
        if (totalQty === 0) {
            panel.classList.add('hidden');
        } else {
            panel.classList.remove('hidden');
        }

        // Update badge
        if (badge) {
            if (totalQty > 0) {
                badge.classList.remove('hidden');
                badge.textContent = totalQty;
            } else {
                badge.classList.add('hidden');
            }
        }

        // Item count label
        if (countEl) {
            countEl.textContent = `${totalQty} ITEMS`;
        }

        // Total
        if (totalEl) {
            totalEl.textContent = formatRp(state.subtotal);
        }

        // Item list
        if (list) {
            list.innerHTML = state.items.map(item => `
                <div class="flex items-center gap-3" data-item-id="${item.product_id}">
                    <div class="flex-1 min-w-0">
                        <p class="text-sm font-semibold text-[#1C1917] truncate">${item.name}</p>
                        <p class="text-xs text-[#78716C]">${formatRp(item.price)}</p>
                    </div>
                    <div class="flex items-center gap-2 flex-shrink-0">
                        <button onclick="cartStore.decreaseQty(${item.product_id})"
                                class="w-6 h-6 flex items-center justify-center rounded-full border border-stone-200 text-[#78716C] hover:border-primary hover:text-primary transition-colors text-sm font-bold">
                            −
                        </button>
                        <span class="text-sm font-semibold text-[#1C1917] w-4 text-center">${item.quantity}</span>
                        <button onclick="cartStore.increaseQty(${item.product_id})"
                                class="w-6 h-6 flex items-center justify-center rounded-full bg-primary text-white hover:bg-[#EA580C] transition-colors text-sm font-bold">
                            +
                        </button>
                    </div>
                </div>
            `).join('');
        }
    }

    function formatRp(amount) {
        return 'Rp' + new Intl.NumberFormat('id-ID').format(amount);
    }

    // ── Init ───────────────────────────────────────────────────────────────────
    function init() {
        // Subscribe to store updates
        cartStore.subscribe(render);

        // Initialize panel drag
        const panel  = document.getElementById('order-panel');
        const handle = document.getElementById('order-panel-handle');

        if (panel && handle) {
            dragModule.enableDrag(panel, handle);
            dragModule.loadPosition(panel);
        }

        // Close panel button
        const closeBtn = document.getElementById('panel-close-btn');
        if (closeBtn) {
            closeBtn.addEventListener('click', () => {
                cartStore.reset();
            });
        }

        // Cart toggle button
        const toggleBtn = document.getElementById('cart-toggle-btn');
        if (toggleBtn) {
            toggleBtn.addEventListener('click', () => {
                const state = cartStore.getState();
                if (state.items.length > 0) {
                    panel?.classList.toggle('hidden');
                }
            });
        }

        // Search
        const searchInput = document.getElementById('search-input');
        if (searchInput) {
            let searchTimer;
            searchInput.addEventListener('input', (e) => {
                clearTimeout(searchTimer);
                searchTimer = setTimeout(() => {
                    const url = new URL(window.location.href);
                    url.searchParams.set('search', e.target.value);
                    window.location.href = url.toString();
                }, 400);
            });
        }

        // Initial render
        render(cartStore.getState());
    }

    return { addToCart, render, init };
})();

window.cartModule = cartModule;
