@extends('layouts.header')

@section('content')
<div class="inventory-page">
    <div class="inventory-topbar">
        <button type="button" class="icon-btn" onclick="window.location.href='{{ url('account') }}'" aria-label="Back to account">
            <i class="bi bi-arrow-left"></i>
        </button>
        <div>
            <h1>Stock Inventory</h1>
            <p>{{ $dealerProfile->store_name ?? auth()->user()->name }}{{ !empty($dealerProfile->area) ? ' - ' . $dealerProfile->area : '' }}</p>
        </div>
        <button type="button" class="icon-btn" id="refreshInventory" aria-label="Refresh inventory">
            <i class="bi bi-arrow-clockwise"></i>
        </button>
    </div>

    <div class="inventory-shell">
        @if(session('success'))
            <div class="inventory-notice success"><i class="bi bi-check-circle"></i>{{ session('success') }}</div>
        @endif
        @if($errors->any())
            <div class="inventory-notice error"><i class="bi bi-exclamation-circle"></i>{{ $errors->first() }}</div>
        @endif
        <div class="summary-grid">
            <div class="summary-card units-card">
                <div class="summary-icon units"><i class="bi bi-box-seam"></i></div>
                <span>Total Units</span>
                <strong>{{ number_format($totalUnits) }}</strong>
            </div>
            <div class="summary-card value-card">
                <div class="summary-icon value"><i class="bi bi-cash-stack"></i></div>
                <span>Stock Value</span>
                <strong>PHP {{ number_format($totalValue, 2) }}</strong>
            </div>
            <div class="summary-card healthy-card">
                <div class="summary-icon healthy"><i class="bi bi-check2-circle"></i></div>
                <span>With Stock</span>
                <strong>{{ number_format($inStockCount) }}</strong>
            </div>
            <div class="summary-card alert-card">
                <div class="summary-icon alert"><i class="bi bi-exclamation-triangle"></i></div>
                <span>Needs Stock</span>
                <strong>{{ number_format($outStockCount + $lowStockCount) }}</strong>
            </div>
        </div>

        <div class="inventory-tools">
            <div class="search-box">
                <i class="bi bi-search"></i>
                <input type="search" id="inventorySearch" placeholder="Search product or SKU">
            </div>

            <div class="filter-tabs" aria-label="Inventory filters">
                <button type="button" class="filter-tab active" data-filter="all">All <span>{{ $totalProducts }}</span></button>
                <button type="button" class="filter-tab" data-filter="healthy">In Stock <span>{{ $inStockCount }}</span></button>
                <button type="button" class="filter-tab" data-filter="low">Low <span>{{ $lowStockCount }}</span></button>
                <button type="button" class="filter-tab" data-filter="out">No Stock <span>{{ $outStockCount }}</span></button>
            </div>
        </div>

        <div class="inventory-list" id="inventoryList">
            @forelse($inventoryItems as $item)
                <article
                    class="inventory-card status-{{ $item['status'] }}"
                    data-status="{{ $item['status'] }}"
                    data-search="{{ strtolower($item['name'] . ' ' . $item['sku'] . ' ' . $item['description']) }}"
                >
                    <div class="product-media">
                        <img
                            src="{{ $item['image'] }}"
                            onerror="this.onerror=null; this.src='{{ asset('images/white_image.png') }}'"
                            alt="{{ $item['name'] }}"
                        >
                    </div>

                    <div class="product-main">
                        <div class="product-heading">
                            <div>
                                <h2>{{ $item['name'] }}</h2>
                                <p>{{ $item['sku'] ? 'SKU: ' . $item['sku'] : 'No SKU' }}</p>
                            </div>
                            <span class="stock-badge {{ $item['status'] }}">{{ $item['status_label'] }}</span>
                        </div>

                        <div class="product-description">
                            {{ $item['description'] ?: 'No description available' }}
                        </div>

                    </div>

                    <div class="stock-numbers">
                        <div>
                            <span>Dealer Stock</span>
                            <strong>{{ number_format($item['dealer_stock']) }}</strong>
                        </div>
                        <div>
                            <span>AD Stock</span>
                            <strong>{{ number_format($item['ad_stock']) }}</strong>
                        </div>
                        <div>
                            <span>Unit Price</span>
                            <strong>PHP {{ number_format($item['price'], 2) }}</strong>
                        </div>
                        <div>
                            <span>Value</span>
                            <strong>PHP {{ number_format($item['value'], 2) }}</strong>
                        </div>
                        <a href="{{ route('dealer.stock.transactions', $item['id']) }}" class="transaction-link">
                            <i class="bi bi-list-check"></i>
                            <span>View Transactions</span>
                            <i class="bi bi-arrow-right-short"></i>
                        </a>
                        @if(auth()->user()->role === 'Dealer' && strtolower(optional(auth()->user()->dealer)->dealer_type) === 'regular' && $item['dealer_stock'] <= 0)
                            <button type="button" class="add-stock-link" data-stock-product="{{ $item['id'] }}" data-stock-name="{{ $item['name'] }}"><i class="bi bi-plus-circle"></i><span>Request item stock</span></button>
                        @endif
                    </div>
                </article>
            @empty
                <div class="inventory-empty">
                    <i class="bi bi-box"></i>
                    <h2>No products found</h2>
                    <p>Activated products for your area will appear here.</p>
                </div>
            @endforelse
        </div>

        <div class="inventory-empty hidden" id="filteredEmpty">
            <i class="bi bi-search"></i>
            <h2>No matching stock items</h2>
            <p>Try a different search or filter.</p>
        </div>
    </div>
</div>
@if(auth()->user()->role === 'Dealer' && strtolower(optional(auth()->user()->dealer)->dealer_type) === 'regular')
<div class="stock-modal" id="stockRequestModal" aria-hidden="true"><div class="stock-modal-backdrop" data-close-stock-modal></div><div class="stock-modal-dialog"><button type="button" class="stock-modal-close" data-close-stock-modal aria-label="Close"><i class="bi bi-x-lg"></i></button><div class="stock-modal-icon"><i class="bi bi-box-seam"></i></div><p class="stock-modal-eyebrow">ADMIN APPROVAL REQUIRED</p><h2>Request item stock</h2><p class="stock-modal-copy">Request stock for <strong id="stockModalProduct">this item</strong>. It will be added only after approval.</p><form method="POST" action="{{ route('dealer.stock.requests.store') }}">@csrf<input type="hidden" name="product_id" id="stockModalProductId"><label>Quantity</label><div class="stock-modal-quantity"><button type="button" data-stock-step="-1">&#8722;</button><input type="number" name="quantity" id="stockModalQuantity" min="1" value="1" required><button type="button" data-stock-step="1">+</button></div><label>Note <span>Optional</span></label><textarea name="notes" rows="3" maxlength="1000" placeholder="Add delivery or stock details"></textarea><button type="submit" class="stock-modal-submit"><i class="bi bi-send"></i> Submit request</button></form></div></div>
@endif
@endsection

@section('css')
<style>
    body {
        background: #eef4f8;
        padding-top: 0 !important;
    }

    .inventory-notice { margin-bottom: 16px; padding: 13px 16px; border-radius: 10px; font-size: 13px; font-weight: 700; }
    .inventory-notice i { margin-right: 8px; }
    .inventory-notice.success { background: #e8f8ee; color: #176a39; }
    .inventory-notice.error { background: #ffeded; color: #a52b2b; }

    .inventory-page {
        min-height: 100vh;
        padding-bottom: 110px;
        color: #172033;
    }

    .inventory-topbar {
        position: sticky;
        top: 0;
        z-index: 20;
        display: grid;
        grid-template-columns: 44px minmax(0, 1fr) 44px;
        align-items: center;
        gap: 12px;
        padding: 16px 18px;
        background: rgba(255, 255, 255, 0.96);
        border-bottom: 1px solid #e6edf5;
        box-shadow: 0 8px 28px rgba(15, 23, 42, 0.07);
        backdrop-filter: blur(12px);
    }

    .inventory-topbar h1 {
        margin: 0;
        font-size: 20px;
        font-weight: 800;
        color: #101828;
    }

    .inventory-topbar p {
        margin: 3px 0 0;
        font-size: 12px;
        color: #667085;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    .icon-btn {
        width: 44px;
        height: 44px;
        border: 0;
        border-radius: 8px;
        background: #e8f7fc;
        color: #1688b3;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        transition: transform 0.18s ease, background 0.18s ease;
    }

    .icon-btn:hover {
        background: #d8f0f8;
        transform: translateY(-1px);
    }

    .icon-btn i {
        font-size: 20px;
    }

    .inventory-shell {
        width: min(1180px, 100%);
        margin: 0 auto;
        padding: 18px;
    }

    .summary-grid {
        display: grid;
        grid-template-columns: repeat(4, minmax(0, 1fr));
        gap: 12px;
        margin-bottom: 16px;
    }

    .summary-card {
        min-height: 116px;
        background: #ffffff;
        border: 1px solid #e8eef6;
        border-radius: 8px;
        padding: 16px;
        box-shadow: 0 10px 30px rgba(15, 23, 42, 0.06);
        position: relative;
        overflow: hidden;
    }

    .summary-card::before {
        content: "";
        position: absolute;
        inset: 0 auto 0 0;
        width: 4px;
        background: #1688b3;
    }

    .summary-card.value-card::before {
        background: #16834a;
    }

    .summary-card.healthy-card::before {
        background: #175cd3;
    }

    .summary-card.alert-card::before {
        background: #c2410c;
    }

    .summary-icon {
        width: 36px;
        height: 36px;
        border-radius: 8px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        margin-bottom: 12px;
    }

    .summary-icon.units {
        background: #e9f7fc;
        color: #1688b3;
    }

    .summary-icon.value {
        background: #ecfdf3;
        color: #16834a;
    }

    .summary-icon.healthy {
        background: #eff8ff;
        color: #175cd3;
    }

    .summary-icon.alert {
        background: #fff7ed;
        color: #c2410c;
    }

    .summary-card span {
        display: block;
        font-size: 12px;
        color: #667085;
        margin-bottom: 4px;
    }

    .summary-card strong {
        display: block;
        font-size: 22px;
        line-height: 1.2;
        color: #101828;
        overflow-wrap: anywhere;
    }

    .inventory-tools {
        display: grid;
        grid-template-columns: minmax(220px, 1fr) auto;
        gap: 12px;
        align-items: center;
        margin-bottom: 14px;
        padding: 12px;
        background: #ffffff;
        border: 1px solid #e8eef6;
        border-radius: 8px;
        box-shadow: 0 8px 24px rgba(15, 23, 42, 0.04);
    }

    .search-box {
        height: 48px;
        display: flex;
        align-items: center;
        gap: 10px;
        padding: 0 14px;
        background: #f8fafc;
        border: 1px solid #d9e4ef;
        border-radius: 8px;
    }

    .search-box:focus-within {
        border-color: #1688b3;
        box-shadow: 0 0 0 3px rgba(22, 136, 179, 0.12);
    }

    .search-box i {
        color: #667085;
        font-size: 18px;
    }

    .search-box input {
        width: 100%;
        border: 0;
        outline: 0;
        color: #101828;
        font-size: 14px;
        background: transparent;
    }

    .filter-tabs {
        display: flex;
        gap: 8px;
        overflow-x: auto;
        padding-bottom: 2px;
    }

    .filter-tab {
        height: 42px;
        border: 1px solid #d9e4ef;
        border-radius: 8px;
        background: #ffffff;
        color: #344054;
        padding: 0 12px;
        font-size: 13px;
        font-weight: 700;
        white-space: nowrap;
        cursor: pointer;
        transition: border-color 0.18s ease, background 0.18s ease, color 0.18s ease;
    }

    .filter-tab:hover {
        border-color: #1688b3;
        color: #1688b3;
    }

    .filter-tab span {
        color: #667085;
        font-weight: 700;
        margin-left: 4px;
    }

    .filter-tab.active {
        background: #1688b3;
        border-color: #1688b3;
        color: #ffffff;
    }

    .filter-tab.active span {
        color: #dff6ff;
    }

    .inventory-list {
        display: grid;
        gap: 12px;
    }

    .inventory-card {
        display: grid;
        grid-template-columns: 88px minmax(0, 1fr) minmax(280px, 360px);
        gap: 16px;
        align-items: center;
        background: #ffffff;
        border: 1px solid #e8eef6;
        border-radius: 8px;
        padding: 14px;
        box-shadow: 0 10px 30px rgba(15, 23, 42, 0.05);
        transition: transform 0.18s ease, box-shadow 0.18s ease, border-color 0.18s ease;
    }

    .inventory-card:hover {
        border-color: #c8d8e5;
        box-shadow: 0 14px 34px rgba(15, 23, 42, 0.08);
        transform: translateY(-1px);
    }

    .inventory-card.status-out {
        border-left: 4px solid #b42318;
    }

    .inventory-card.status-low {
        border-left: 4px solid #c2410c;
    }

    .inventory-card.status-healthy {
        border-left: 4px solid #16834a;
    }

    .product-media {
        width: 88px;
        aspect-ratio: 1;
        border-radius: 8px;
        background: #f8fafc;
        border: 1px solid #edf2f7;
        display: flex;
        align-items: center;
        justify-content: center;
        overflow: hidden;
    }

    .product-media img {
        width: 100%;
        height: 100%;
        object-fit: contain;
    }

    .product-heading {
        display: flex;
        align-items: flex-start;
        justify-content: space-between;
        gap: 12px;
        margin-bottom: 8px;
    }

    .product-heading h2 {
        margin: 0;
        font-size: 16px;
        font-weight: 800;
        color: #101828;
    }

    .product-heading p,
    .product-description {
        margin: 4px 0 0;
        font-size: 12px;
        color: #667085;
    }

    .product-description {
        line-height: 1.5;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }

    .stock-badge {
        border-radius: 999px;
        padding: 6px 10px;
        font-size: 11px;
        font-weight: 800;
        white-space: nowrap;
    }

    .stock-badge.healthy {
        background: #ecfdf3;
        color: #16834a;
    }

    .stock-badge.low {
        background: #fff7ed;
        color: #c2410c;
    }

    .stock-badge.out {
        background: #fef2f2;
        color: #b42318;
    }

    .stock-numbers {
        display: grid;
        grid-template-columns: repeat(2, minmax(0, 1fr));
        gap: 8px;
    }

    .stock-numbers div {
        min-height: 68px;
        border-radius: 8px;
        background: #f8fafc;
        border: 1px solid #edf2f7;
        padding: 10px;
    }

    .stock-numbers span {
        display: block;
        font-size: 12px;
    }

    .stock-numbers strong {
        display: block;
        font-size: 15px;
        color: #101828;
        overflow-wrap: anywhere;
    }

    .transaction-link {
        grid-column: 1 / -1;
        min-height: 46px;
        border-radius: 8px;
        background: #1688b3;
        color: #ffffff;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        text-decoration: none;
        font-size: 13px;
        font-weight: 800;
        transition: transform 0.18s ease, background 0.18s ease, box-shadow 0.18s ease;
    }

    .transaction-link:hover {
        color: #ffffff;
        background: #0f7298;
        box-shadow: 0 10px 22px rgba(22, 136, 179, 0.22);
        transform: translateY(-1px);
    }

    .add-stock-link { grid-column: 1 / -1; min-height: 42px; border: 1px solid #1688b3; border-radius: 8px; color: #1688b3; background: #f0fbff; display: inline-flex; align-items: center; justify-content: center; gap: 8px; text-decoration: none; font: inherit; font-size: 13px; font-weight: 800; cursor: pointer; }
    .add-stock-link:hover { color: #0f7298; border-color: #0f7298; background: #e0f5fb; }
    .stock-modal { display:none; position:fixed; inset:0; z-index:1000; align-items:center; justify-content:center; padding:18px; }
    .stock-modal.is-open { display:flex; }
    .stock-modal-backdrop { position:absolute; inset:0; background:rgba(15,32,51,.62); backdrop-filter:blur(3px); }
    .stock-modal-dialog { position:relative; width:min(100%,460px); padding:28px; border-radius:18px; background:#fff; box-shadow:0 24px 70px rgba(15,32,51,.28); }
    .stock-modal-close { position:absolute; top:14px; right:14px; width:34px; height:34px; border:0; border-radius:50%; background:#f1f5f8; color:#667085; cursor:pointer; }
    .stock-modal-icon { width:48px; height:48px; border-radius:14px; display:grid; place-items:center; background:#e6f8fc; color:#078db2; font-size:23px; }
    .stock-modal-eyebrow { margin:18px 0 5px; color:#078db2; font-size:11px; letter-spacing:.1em; font-weight:800; }
    .stock-modal-dialog h2 { margin:0; color:#152238; font-size:24px; }
    .stock-modal-copy { margin:8px 0 20px; color:#667085; font-size:14px; line-height:1.55; }
    .stock-modal-dialog label { display:block; margin:15px 0 7px; color:#344054; font-size:13px; font-weight:800; }
    .stock-modal-dialog label span { color:#98a2b3; font-weight:500; }
    .stock-modal-dialog textarea { width:100%; resize:vertical; border:1px solid #d0dbe5; border-radius:9px; padding:11px; outline:0; }
    .stock-modal-quantity { display:flex; width:155px; overflow:hidden; border:1px solid #d0dbe5; border-radius:9px; }
    .stock-modal-quantity button { width:42px; border:0; background:#eefafd; color:#078db2; font-size:21px; cursor:pointer; }
    .stock-modal-quantity input { width:71px; border:0; text-align:center; font-weight:800; outline:0; }
    .stock-modal-submit { width:100%; margin-top:21px; padding:13px; border:0; border-radius:9px; background:#078db2; color:#fff; font-size:14px; font-weight:800; cursor:pointer; }
    body.stock-modal-open { overflow:hidden; }

    .inventory-empty {
        text-align: center;
        padding: 52px 20px;
        background: #ffffff;
        border: 1px solid #e8eef6;
        border-radius: 8px;
        color: #667085;
    }

    .inventory-empty i {
        font-size: 42px;
        color: #b8c4d2;
        margin-bottom: 12px;
    }

    .inventory-empty h2 {
        margin: 0 0 6px;
        font-size: 18px;
        color: #101828;
        font-weight: 800;
    }

    .inventory-empty p {
        margin: 0;
        font-size: 13px;
    }

    .hidden {
        display: none !important;
    }

    @media (max-width: 980px) {
        .summary-grid {
            grid-template-columns: repeat(2, minmax(0, 1fr));
        }

        .inventory-tools {
            grid-template-columns: 1fr;
        }

        .filter-tabs {
            width: 100%;
        }

        .inventory-card {
            grid-template-columns: 76px minmax(0, 1fr);
        }

        .product-media {
            width: 76px;
        }

        .stock-numbers {
            grid-column: 1 / -1;
            grid-template-columns: repeat(4, minmax(0, 1fr));
        }
    }

    @media (max-width: 640px) {
        .inventory-shell {
            padding: 14px;
        }

        .summary-grid {
            grid-template-columns: 1fr 1fr;
            gap: 10px;
        }

        .summary-card {
            min-height: 106px;
            padding: 13px;
        }

        .summary-card strong {
            font-size: 18px;
        }

        .inventory-card {
            grid-template-columns: 68px minmax(0, 1fr);
            gap: 12px;
            padding: 12px;
        }

        .inventory-card:hover {
            transform: none;
        }

        .product-media {
            width: 68px;
        }

        .product-heading {
            display: block;
        }

        .stock-badge {
            display: inline-flex;
            margin-top: 8px;
        }

        .stock-numbers {
            grid-template-columns: repeat(2, minmax(0, 1fr));
        }
    }
</style>
@endsection

@section('js')
<script>
    const searchInput = document.getElementById('inventorySearch');
    const filterButtons = document.querySelectorAll('.filter-tab');
    const cards = document.querySelectorAll('.inventory-card');
    const filteredEmpty = document.getElementById('filteredEmpty');
    let activeFilter = 'all';

    function applyInventoryFilters() {
        const query = (searchInput?.value || '').trim().toLowerCase();
        let visibleCount = 0;

        cards.forEach((card) => {
            const matchesFilter = activeFilter === 'all' || card.dataset.status === activeFilter;
            const matchesSearch = !query || card.dataset.search.includes(query);
            const isVisible = matchesFilter && matchesSearch;

            card.classList.toggle('hidden', !isVisible);
            if (isVisible) visibleCount++;
        });

        if (filteredEmpty) {
            filteredEmpty.classList.toggle('hidden', visibleCount !== 0 || cards.length === 0);
        }
    }

    searchInput?.addEventListener('input', applyInventoryFilters);

    filterButtons.forEach((button) => {
        button.addEventListener('click', () => {
            filterButtons.forEach((item) => item.classList.remove('active'));
            button.classList.add('active');
            activeFilter = button.dataset.filter || 'all';
            applyInventoryFilters();
        });
    });

    document.getElementById('refreshInventory')?.addEventListener('click', () => {
        window.location.reload();
    });

    const stockModal = document.getElementById('stockRequestModal');
    const stockProductId = document.getElementById('stockModalProductId');
    const stockProductName = document.getElementById('stockModalProduct');
    const stockQuantity = document.getElementById('stockModalQuantity');
    function closeStockModal() { stockModal?.classList.remove('is-open'); document.body.classList.remove('stock-modal-open'); }
    document.querySelectorAll('[data-stock-product]').forEach((button) => button.addEventListener('click', () => {
        stockProductId.value = button.dataset.stockProduct; stockProductName.textContent = button.dataset.stockName; stockQuantity.value = 1;
        stockModal.classList.add('is-open'); document.body.classList.add('stock-modal-open'); stockQuantity.focus();
    }));
    document.querySelectorAll('[data-close-stock-modal]').forEach((button) => button.addEventListener('click', closeStockModal));
    document.querySelectorAll('[data-stock-step]').forEach((button) => button.addEventListener('click', () => { stockQuantity.value = Math.max(1, Number(stockQuantity.value || 1) + Number(button.dataset.stockStep)); }));
    document.addEventListener('keydown', (event) => { if (event.key === 'Escape') closeStockModal(); });
</script>
@endsection
