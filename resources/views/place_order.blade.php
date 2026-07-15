
@extends('layouts.header')

@section('content')

@section('css')
  <link href="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/11.10.1/sweetalert2.min.css" rel="stylesheet">
  
  <style>
    .content-area-fix {
        margin-top: -80px;
    }

    .back-btn {
      background: none;
      border: none;
      color: #666;
      font-size: 18px;
      cursor: pointer;
      padding: 5px;
      transition: color 0.2s ease;
      text-decoration: none;
    }

    .back-btn:hover {
      color: #4A90E2;
    }

    .page-title {
        font-size: 20px;
        font-weight: 600;
        color: #4A90E2;
    }

    .page-header-nya {
      outline: 0.2px solid #e1e1e1ff;
    }

    .section-card .bi-truck {
      color: #000000ff;
    }

    .section-card {
      box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
      overflow: hidden;
    }

    .section-header {
      font-size: 18px;
      font-weight: 600;
      color: #333 !important;
    }

    .customer-display {
      border: 2px solid #e1e8ed;
      transition: all 0.3s ease;
    }

    .customer-display:hover {
      border-color: #4A90E2;
      box-shadow: 0 2px 8px rgba(74, 144, 226, 0.1);
    }

    .customer-name {
      font-size: 16px;
      color: #333;
      margin-bottom: 4px;
    }

    .customer-details {
      font-size: 13px;
      color: #666;
    }

    .customer-icon {
      transition: transform 0.3s ease;
    }

    .customer-display:hover .customer-icon {
      transform: scale(1.05);
    }

    .info-row {
      font-size: 14px !important;
    }

    .info-row:last-child {
      font-size: 16px !important;
      font-weight: 700;
      color: #4A90E2;
    }

    .info-label {
      color: #606060ff !important;
    }

    .info-value {
      color: #333 !important;
      font-weight: 600 !important;
    }

    .other-charges-row {
      background: #f8fbff;
    }

    .discount-summary-row {
      background: #f0fdf4;
      border-top: 1px solid #dcfce7;
      border-bottom: 1px solid #dcfce7;
    }

    .other-charges-row .info-label,
    .discount-summary-row .info-label {
      display: flex;
      flex-direction: column;
      gap: 2px;
    }

    .other-charges-title,
    .discount-title {
      display: inline-flex;
      align-items: center;
      gap: 6px;
      font-weight: 700;
    }

    .other-charges-title {
      color: #1d4ed8;
    }

    .discount-title {
      color: #15803d;
    }

    .other-charges-row small,
    .discount-summary-row small {
      color: #64748b;
      font-size: 11px;
      line-height: 1.35;
    }

    .charge-item {
      display: flex;
      justify-content: space-between;
      align-items: center;
      padding: 6px 0;
      font-size: 12px;
      border-top: 1px solid #e5e7eb;
      margin-top: 6px;
      padding-top: 6px;
    }

    .charge-item:first-of-type {
      border-top: none;
      margin-top: 0;
      padding-top: 0;
    }

    .charge-item-name {
      color: #374151;
      font-weight: 500;
    }

    .discount-item .charge-item-name,
    .discount-item .charge-item-amount,
    #ad-discount {
      color: #15803d !important;
    }

    .charge-item-amount {
      color: #1d4ed8;
      font-weight: 600;
      white-space: nowrap;
      margin-left: 8px;
    }

    #other-charges {
      color: #1d4ed8 !important;
      white-space: nowrap;
    }

    .order-item {
      display: flex;
      justify-content: space-between;
      align-items: center;
      padding: 8px 0;
      font-size: 13px;
    }

    .item-info {
      flex-grow: 1;
    }

    .quantity-item {
      display: inline-flex;
      align-items: center;
      justify-content: center;
      width: 28px;
      height: 28px;
      background-color: #1976d2;
      color: #fff;
      font-weight: 600;
      font-size: 14px;
      border-radius: 6px;
      margin-right: 10px;
    }

    .item-name {
      color: #333;
      font-weight: 500;
      margin-bottom: 2px;
    }

    .item-details {
      color: #666;
      font-size: 12px;
    }

    .item-total {
      color: #4A90E2;
      font-weight: 600;
    }

    .payment-method-display {
      background: #f8f9fa;
      border: 2px solid #e1e8ed;
    }

    .payment-icon {
      width: 40px;
      height: 40px;
      background: #4A90E2;
      font-size: 18px;
      color: white;
    }

    .payment-icon.cod {
      background: #28a745;
    }
    .payment-icon.credit {
      background: #d72f2f;
    }
    .payment-icon.gcash {
      background: #007DFF;
    }

    .payment-name {
      font-size: 14px;
      font-weight: 600;
      color: #333;
      margin-bottom: 2px;
    }

    .payment-desc {
      font-size: 12px;
      color: #666;
    }

    .complete-order-wrapper {
      bottom: 120px;
      left: var(--sidebar-width);
      right: 0;
      transition: left var(--transition-duration) ease;
      background: transparent;
      pointer-events: none;
    }

    .complete-order-btn {
      pointer-events: auto;
      background: linear-gradient(135deg, #28a745 0%, #20c997 100%);
      border: none;
      font-size: 16px;
      box-shadow: 0 4px 12px rgba(40, 167, 69, 0.4);
      transition: all 0.2s ease;
    }

    .complete-order-btn:hover {
      background: linear-gradient(135deg, #28a745 0%, #20c997 100%);
      transform: translateY(-2px);
      box-shadow: 0 6px 16px rgba(40, 167, 69, 0.5);
    }

    .complete-order-btn:active {
      transform: scale(0.98);
    }

    .complete-order-btn:disabled {
      background: #ccc;
      cursor: not-allowed;
      box-shadow: none;
    }

    .sidebar.collapsed ~ .main-content .complete-order-wrapper {
      left: var(--sidebar-collapsed-width);
    }

    @keyframes checkmark {
      0% { transform: scale(0); }
      50% { transform: scale(1.2); }
      100% { transform: scale(1); }
    }

    .success-checkmark {
      animation: checkmark 0.3s ease-in-out;
    }

    @keyframes slideInUp {
      from {
        transform: translateY(50px);
        opacity: 0;
      }
      to {
        transform: translateY(0);
        opacity: 1;
      }
    }

    @keyframes pulse {
      0%, 100% { opacity: 1; }
      50% { opacity: 0.5; }
    }

    .customer-name:empty::before,
    .customer-details:empty::before {
      content: 'Loading...';
      animation: pulse 1.5s ease-in-out infinite;
    }

    .swal2-popup {
      border-radius: 16px !important;
      box-shadow: 0 20px 60px rgba(0, 0, 0, 0.15) !important;
    }
    
    .swal2-title {
      font-weight: 700 !important;
      color: #333 !important;
      font-size: 1.5em !important;
    }
    
    .swal2-html-container {
      font-weight: 400 !important;
      line-height: 1.6 !important;
      color: #555 !important;
    }
    
    .swal2-confirm {
      background: linear-gradient(135deg, #28a745 0%, #20c997 100%) !important;
      border: none !important;
      border-radius: 10px !important;
      font-weight: 600 !important;
      padding: 12px 24px !important;
      box-shadow: 0 4px 12px rgba(40, 167, 69, 0.4) !important;
    }
    
    .swal2-confirm:hover {
      transform: translateY(-2px) !important;
      box-shadow: 0 6px 16px rgba(40, 167, 69, 0.5) !important;
    }
    
    .swal2-deny {
      background: linear-gradient(135deg, #4A90E2 0%, #357ABD 100%) !important;
      border: none !important;
      border-radius: 10px !important;
      font-weight: 600 !important;
      padding: 12px 24px !important;
      box-shadow: 0 4px 12px rgba(74, 144, 226, 0.4) !important;
    }
    
    .swal2-cancel {
      background: linear-gradient(135deg, #6c757d 0%, #5a6268 100%) !important;
      border: none !important;
      border-radius: 10px !important;
      font-weight: 600 !important;
      padding: 12px 24px !important;
      box-shadow: 0 4px 12px rgba(108, 117, 125, 0.4) !important;
    }
    
    .swal2-timer-progress-bar {
      background: linear-gradient(135deg, #28a745 0%, #20c997 100%) !important;
    }
    
    .swal2-icon.swal2-success {
      border-color: #28a745 !important;
      color: #28a745 !important;
    }

    @media (max-width: 768px) {
      .complete-order-wrapper {
        left: 0 !important;
        right: 0;
        bottom: 120px;
        z-index: 1100;
      }
    }

    @media (max-width: 480px) {
      .section-card {
        margin: 10px;
      }
      
      .section-header {
        padding: 15px;
        font-size: 16px !important;
      }
      
      .section-content {
        padding: 15px;
      }
      
      .info-row {
        padding: 10px 0;
        font-size: 13px !important;
      }
      
      .complete-order-btn {
        padding: 14px 18px;
        font-size: 15px;
      }

      .customer-display {
        gap: 10px !important;
      }

      .customer-icon {
        width: 45px !important;
        height: 45px !important;
      }

      .customer-name {
        font-size: 15px !important;
      }

      .customer-details {
        font-size: 12px;
      }
    }
  </style>
@endsection

<meta name="csrf-token" content="{{ csrf_token() }}">

<div class="order-payment-page">
  <div class="content-area-fix">
    <div class="page-header-nya bg-white border-bottom">
      <div class="d-flex justify-content-between align-items-center position-relative px-3 py-3">
        <button class="btn btn-link back-btn p-1" onclick="history.back()">
          <i class="bi bi-arrow-left"></i>
        </button>
        <h1 class="page-title position-absolute start-50 translate-middle-x m-0">Order Payment</h1>
      </div>
    </div>

    <div class="section-card mx-3 my-3 bg-white rounded-3 shadow-sm">
      <div class="section-header d-flex align-items-center gap-2 p-3 border-bottom">
        <i class="bi bi-person-circle"></i>
        <span>Payment Details</span>
      </div>
      <div class="section-content p-3">
        <div class="customer-display d-flex align-items-center gap-3 p-3 rounded-2 bg-light">
          <div class="customer-icon rounded-circle d-flex align-items-center justify-content-center flex-shrink-0" style="width: 50px; height: 50px; background: #D6F4FF;">
            <i class="bi bi-person-fill" style="font-size: 24px; color: #4A90E2;"></i>
          </div>
          <div class="customer-info flex-grow-1">
            <div class="customer-name fw-semibold" id="customer-name-display">Loading...</div>
            <div class="customer-details small text-muted" id="customer-details-display">Loading customer details...</div>
          </div>
        </div>
      </div>
    </div>

    <div class="section-card mx-3 my-3 bg-white rounded-3 shadow-sm">
      <div class="section-header d-flex align-items-center gap-2 p-3 border-bottom">
        <i class="bi bi-receipt"></i>
        <span>Order Summary</span>
      </div>
      <div class="section-content p-3">
        <div class="info-row d-flex justify-content-between align-items-center py-2 border-bottom">
          <span class="info-label">Payment Method:</span>
          <span class="info-value fw-semibold" id="payment-method">Cash on Delivery</span>
        </div>
        <div class="info-row d-flex justify-content-between align-items-center py-2 border-bottom">
          <span class="info-label">Delivery Method:</span>
          <span class="info-value fw-semibold" id="delivery-method">Pickup</span>
        </div>
        <div class="info-row d-flex justify-content-between align-items-center py-2 border-bottom">
          <span class="info-label">Total Items:</span>
          <span class="info-value fw-semibold" id="total-items">0</span>
        </div>
        <div id="ad-discount-row" class="info-row discount-summary-row d-flex justify-content-between align-items-start py-2 border-bottom" style="display:none !important;">
          <span class="info-label">
            <span class="discount-title">
              <i class="bi bi-tag-fill"></i>
              <span>AD Discount</span>
            </span>
            <small>Applied by the assigned Area Distributor</small>
            <div id="discount-items-list" style="margin-top: 8px;"></div>
          </span>
          <span class="info-value fw-semibold" id="ad-discount">-₱ 0.00</span>
        </div>
        <div id="other-charges-row" class="info-row other-charges-row d-flex justify-content-between align-items-start py-2 border-bottom" style="display:block !important;">
          <span class="info-label">
            <span class="other-charges-title">
              <i class="bi bi-receipt-cutoff"></i>
              <span id="other-charges-title">AD Other Charges</span>
            </span>
            {{-- <small id="other-charges-description">Applied by the assigned Area Distributor</small> --}}
            <div id="other-charges-items-list" style="margin-top: 8px;"></div>
          </span>
          <span class="info-value fw-semibold" id="other-charges">₱ 0.00</span>
        </div>
        <div class="info-row d-flex justify-content-between align-items-center py-3 bg-light mx-n3 mb-n3">
          <span class="info-label">Total Amount:</span>
          <span class="info-value fw-bold" id="order-total">₱ 0.00</span>
        </div>
        
        <div class="order-items border-top mt-3 pt-3" id="order-items-list">
          <!-- Items will be dynamically loaded -->
        </div>
      </div>
    </div>

    <div class="section-card mx-3 my-3 bg-white rounded-3 shadow-sm">
      <div class="section-header d-flex align-items-center gap-2 p-3 border-bottom">
        <i class="bi bi-credit-card"></i>
        <span>Payment Details</span>
      </div>
      <div class="section-content p-3">
        <div class="mb-3">
          <label class="form-label fw-semibold">Selected Payment Method</label>
          <div class="payment-method-display d-flex align-items-center gap-3 p-3 rounded-2" id="payment-method-display">
            <div class="payment-icon rounded-2 d-flex align-items-center justify-content-center flex-shrink-0">
              <i class="bi bi-cash-coin"></i>
            </div>
            <div class="payment-details flex-grow-1">
              <div class="payment-name fw-semibold">Cash on Delivery</div>
              <div class="payment-desc small text-muted">Customer pays upon delivery</div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="complete-order-wrapper px-3 mt-3">
      <button class="btn btn-success complete-order-btn w-100 d-flex align-items-center justify-content-center gap-2 py-3 rounded-3 fw-semibold" id="complete-order-btn">
        <i class="bi bi-check-circle"></i>
        <span>Place Order</span>
      </button>
    </div>
  </div>
</div>
@endsection

@section('js')
<script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/11.10.1/sweetalert2.all.min.js"></script>

<script>
  document.addEventListener('DOMContentLoaded', function() {
    // let orderData = {};
    // let orderData = {
    //     transaction_type: 'client_transaction',
    //     customer: null,
    //     ad: null,
    //     payment_method: 'cash',
    //     total_amount: 0
    // };
    // let dealerCartData = [];
    // let customerData = null;
    
    // try {
    //     // let storedOrderData = localStorage.getItem('dealerOrderData');
    //     // if (!storedOrderData) {
    //     //     storedOrderData = localStorage.getItem('orderData');
    //     // }
    //     let storedOrderData = localStorage.getItem('dealerOrderData') 
    //                 || localStorage.getItem('orderData');

    //     if (storedOrderData) {
    //         const parsed = JSON.parse(storedOrderData);

    //         orderData = {
    //             transaction_type: parsed.transaction_type || 'client_transaction',
    //             customer: parsed.customer || null,
    //             ad: parsed.ad || null,
    //             payment_method: parsed.payment_method || 'cash',
    //             total_amount: parsed.total_amount || 0
    //         };

    //         customerData = orderData.customer;
    //     }
        
    //     const storedDealerCartData = localStorage.getItem('dealerCartData');
        
    //     // if (storedOrderData) {
    //     //     // orderData = JSON.parse(storedOrderData);
    //     //     // customerData = orderData.customer;
    //     //     // console.log('Loaded order data:', orderData);
    //     //     const orderData = {
    //     //       items: dealerCartData,
    //     //       transaction_type: transactionType, // ✅ IMPORTANT
    //     //       customer: customerData,
    //     //       ad: transactionType === 'ad_order' ? window.matchedAD : null,
    //     //       payment_method: paymentMethod,
    //     //       subtotal: subtotal,
    //     //       total: total,
    //     //       created_at: new Date().toISOString()
    //     //   };
    //     // }
        
    //     if (storedDealerCartData) {
    //         dealerCartData = JSON.parse(storedDealerCartData);
    //         console.log('Loaded cart data:', dealerCartData);
    //     }
    // } catch (error) {
    //     console.error('Error loading order data:', error);
    //     Swal.fire({
    //         title: 'Error Loading Data',
    //         text: 'Error loading order data. Please go back and try again.',
    //         icon: 'error',
    //         confirmButtonText: 'Go Back'
    //     }).then(() => {
    //         history.back();
    //     });
    //     return;
    // }
    let orderData = {
        transaction_type: 'client_transaction',
        customer: null,
        ad: null,
        payment_method: 'cash',
        total_amount: 0
    };

    // let orderData = {};
    let dealerCartData = [];
    let customerData = null;
    let adData = null;

    try {
        // Try to get from dealerOrderData first (new key from cart.blade.php)
        let storedOrderData = localStorage.getItem('dealerOrderData');
        if (!storedOrderData) {
            // Fallback to orderData (old key)
            storedOrderData = localStorage.getItem('orderData');
        }
        
        if (storedOrderData) {
            orderData = JSON.parse(storedOrderData);
            console.log('Loaded order data:', orderData);
        }

        orderData.delivery_type = orderData.delivery_type || localStorage.getItem('selectedDeliveryType') || 'pickup';

        dealerCartData = JSON.parse(localStorage.getItem('dealerCartData')) || [];

        customerData = orderData.customer || null;

        if (!customerData || !customerData.id) {
            const customerId = localStorage.getItem('selectedCustomerId');
            const customerName = localStorage.getItem('selectedCustomerName');
            const customerSerial = localStorage.getItem('selectedCustomerSerial');
            const customerNumber = localStorage.getItem('selectedCustomerNumber');

            if (customerId && customerId !== 'null' && customerId !== 'undefined') {
                customerData = {
                    id: customerId,
                    name: customerName || 'Selected Customer',
                    serial: customerSerial || '',
                    number: customerNumber || ''
                };

                orderData.customer = customerData;
            }
        }
        
        // Get AD data - priority from orderData.ad, fallback to localStorage
        if (orderData.ad && orderData.ad.id) {
            adData = orderData.ad;
        } else {
            // Try to get from localStorage (set by cart.blade.php)
            const adId = localStorage.getItem('selectedADId');
            const adName = localStorage.getItem('selectedADName');
            const adArea = localStorage.getItem('selectedADArea');
            
            if (adId && adName) {
                adData = {
                    id: adId,
                    name: adName,
                    area: adArea || ''
                };
            }
        }
        
        console.log('AD Data:', adData);
        console.log('Transaction Type:', orderData.transaction_type);

    } catch (error) {
        console.error('Storage error:', error);
    }

    // function displayCustomerDetails() {
    //     const customerNameDisplay = document.getElementById('customer-name-display');
    //     const customerDetailsDisplay = document.getElementById('customer-details-display');
        
    //     let customer = customerData || orderData.customer;
        
    //     if (!customer || !customer.id) {
    //         const customerId = localStorage.getItem('selectedCustomerId');
    //         const customerName = localStorage.getItem('selectedCustomerName');
    //         const customerSerial = localStorage.getItem('selectedCustomerSerial');
    //         const customerNumber = localStorage.getItem('selectedCustomerNumber');
            
    //         if (customerId && customerName) {
    //             customer = {
    //                 id: customerId,
    //                 name: customerName,
    //                 serial: customerSerial,
    //                 number: customerNumber
    //             };
    //             customerData = customer;
    //         }
    //     }
        
    //     if (customer && customer.id) {
    //         customerNameDisplay.textContent = customer.name;
            
    //         const detailsParts = [];
    //         if (customer.serial) detailsParts.push(`Serial: ${customer.serial}`);
    //         if (customer.number) detailsParts.push(`Number: ${customer.number}`);
            
    //         customerDetailsDisplay.textContent = detailsParts.join(' • ');
            
    //         console.log('Displaying customer:', customer);
    //     } else {
    //         customerNameDisplay.textContent = 'No Customer Selected';
    //         customerDetailsDisplay.textContent = '';
            
    //         Swal.fire({
    //             title: 'No Customer Selected',
    //             text: 'Please go back and select a customer.',
    //             icon: 'warning',
    //             confirmButtonText: 'Go Back'
    //         }).then(() => {
    //             history.back();
    //         });
    //     }
    // }
    function displayCustomerDetails() {
        const nameDisplay = document.getElementById('customer-name-display');
        const detailsDisplay = document.getElementById('customer-details-display');

        if (!nameDisplay || !detailsDisplay) {
            return;
        }

        // =========================
        // AD ORDER
        // =========================
        if (orderData.transaction_type === 'ad_order') {

            if (!adData || !adData.id) {
                nameDisplay.textContent = 'No Area Distributor Selected';
                detailsDisplay.textContent = '';

                Swal.fire({
                    title: 'Missing AD',
                    text: 'Please select Area Distributor again.',
                    icon: 'warning'
                }).then(() => history.back());

                return;
            }
            
            nameDisplay.textContent = adData.name;

            let details = [];
            if (adData.areas && adData.areas.length > 0) {
              const areaNames = adData.areas
                  .map(area => area.area_name)
                  .filter(Boolean);

              details.push(`Areas: ${areaNames.join(', ')}`);
            }
            if (adData.address) details.push(`Address: ${adData.address}`);

            if (!details.length) {
                detailsDisplay.textContent = 'No area details available';
                return;
            }

            detailsDisplay.textContent = details.join(' • ');
            return;
        }

        // =========================
        // CLIENT ORDER
        // =========================
        const customer = customerData || orderData.customer;

        if (!customer || !customer.id) {
            nameDisplay.textContent = 'No Customer Selected';
            detailsDisplay.textContent = 'Please go back and select a customer.';
            return;
        }

        nameDisplay.textContent = customer.name || 'Selected Customer';

        if (['guest', 'others'].includes(String(customer.id))) {
            detailsDisplay.textContent = 'No points will be awarded for this transaction.';
            return;
        }

        let details = [];
        if (customer.serial) details.push(`Serial: ${customer.serial}`);
        if (customer.number) details.push(`Number: ${customer.number}`);

        if (!details.length) {
            detailsDisplay.textContent = 'No customer details available';
            return;
        }

        detailsDisplay.textContent = details.join(' • ');
    }

    window.matchedAD = JSON.parse(localStorage.getItem('selectedAD') || 'null');
    window.authDealerType = @json(optional(auth()->user()->dealer)->dealer_type);
    window.authDealerStoreType = @json(optional(auth()->user()->dealer)->store_type);

    function parseMoney(value) {
      if (value === null || value === undefined || value === '') return 0;

      if (typeof value === 'number') {
        return Number.isFinite(value) ? value : 0;
      }

      const cleaned = String(value).replace(/[^0-9.-]/g, '');
      const amount = parseFloat(cleaned);

      return Number.isFinite(amount) ? amount : 0;
    }

    // function initializeOrderPage() {
    //     const orderId = 'ORD-' + Date.now().toString().slice(-6);
        
    //     const totalItems = dealerCartData.reduce((sum, item) => sum + item.quantity, 0);
    //     const totalAmount = dealerCartData.reduce((sum, item) => sum + (item.price * item.quantity), 0);
        
    //     document.getElementById('total-items').textContent = totalItems;
    //     document.getElementById('order-total').textContent = '₱ ' + totalAmount.toFixed(2);
        
    //     const paymentMethod = orderData.payment_method || 'cash';
    //     updatePaymentMethodDisplay(paymentMethod);
        
    //     displayOrderItems();
    //     displayCustomerDetails();
        
    //     orderData.order_id = orderId;
    //     orderData.total_amount = totalAmount;
    // }
    function initializeOrderPage() {
      const orderId = 'ORD-' + Date.now().toString().slice(-6);

      const totalItems = dealerCartData.reduce((sum, item) => sum + item.quantity, 0);
      const subtotalAmount = dealerCartData.reduce((sum, item) => sum + (item.price * item.quantity), 0);
      const isADOrder = orderData.transaction_type === 'ad_order';
      const otherCharges = isADOrder
        ? parseMoney(orderData.delivery_fee || orderData.other_charges || 0)
        : 0;
      const adChargeTotal = isADOrder
        ? parseMoney(orderData.ad_charge_total ?? orderData.other_charges ?? 0)
        : 0;
      const discountTotal = isADOrder
        ? parseMoney(orderData.discount_total || 0)
        : 0;
      const totalAmount = subtotalAmount + otherCharges;

      document.getElementById('total-items').textContent = totalItems;
      const discountRow = document.getElementById('ad-discount-row');
      const discountElement = document.getElementById('ad-discount');
      const discountItemsList = document.getElementById('discount-items-list');
      const otherChargesRow = document.getElementById('other-charges-row');
      const otherChargesElement = document.getElementById('other-charges');
      const otherChargesTitle = document.getElementById('other-charges-title');
      const otherChargesDescription = document.getElementById('other-charges-description');
      const otherChargesItemsList = document.getElementById('other-charges-items-list');

      if (otherChargesRow && otherChargesElement) {
        // For AD orders with regular dealer, always show the row initially (charges will be fetched)
        const isRegularDealer = window.authDealerType === 'regular';
        if (isADOrder && isRegularDealer) {
          otherChargesRow.style.setProperty('display', 'flex', 'important');
        } else {
          otherChargesRow.style.setProperty('display', otherCharges > 0 ? 'flex' : 'none', 'important');
        }
        otherChargesElement.textContent = '₱ ' + adChargeTotal.toFixed(2);
      }
      if (discountRow) {
        discountRow.style.setProperty('display', discountTotal > 0 ? 'flex' : 'none', 'important');
      }
      if (discountElement) {
        discountElement.textContent = '-₱ ' + discountTotal.toFixed(2);
      }
      if (discountItemsList) {
        displayDiscountItems(orderData.discount_items || [], discountItemsList);
      }
      if (otherChargesRow && isADOrder && adChargeTotal <= 0 && discountTotal > 0) {
        otherChargesRow.style.setProperty('display', 'none', 'important');
      }
      if (otherChargesTitle) {
        otherChargesTitle.textContent = orderData.other_charge_label || 'AD Other Charges';
      }
      if (otherChargesDescription) {
        otherChargesDescription.textContent = orderData.other_charge_description || 'Applied by the assigned Area Distributor';
      }

      // Display charge items if available from localStorage first
      const chargeOnlyItems = orderData.other_charge_only_items
        || (orderData.other_charge_items || []).filter(item => !chargeItemIsDiscount(item));
      if (otherChargesItemsList && chargeOnlyItems.length > 0) {
        displayChargeItems(chargeOnlyItems, otherChargesItemsList);
      } else if (isADOrder && window.authDealerType === 'regular' && adData?.id) {
        // Otherwise fetch from database (only for regular dealers on AD orders)
        fetchAndDisplayADCharges(adData.id, otherChargesItemsList, otherChargesElement, subtotalAmount);
      }

      document.getElementById('order-total').textContent = '₱ ' + totalAmount.toFixed(2);

      orderData.total_amount = totalAmount;
      // orderData.delivery_fee = otherCharges;
      orderData.other_charges = otherCharges;

      updatePaymentMethodDisplay(orderData.payment_method);
      updateDeliveryMethodDisplay(orderData.delivery_type);
      displayOrderItems();
      displayCustomerDetails();

      // displayTransactionType(); // ✅ AD / CLIENT DETECT

      orderData.order_id = orderId;
    }

    function escapeHTML(value) {
      return String(value ?? '')
        .replace(/&/g, '&amp;')
        .replace(/</g, '&lt;')
        .replace(/>/g, '&gt;')
        .replace(/"/g, '&quot;')
        .replace(/'/g, '&#039;');
    }

    function chargeItemIsDiscount(chargeItem) {
      const type = String(chargeItem?.type ?? chargeItem?.charge_type ?? '').toLowerCase();
      const name = String(chargeItem?.name ?? chargeItem?.charge_name ?? '').toLowerCase();

      return type.includes('discount') || name.includes('discount') || parseMoney(chargeItem?.amount) < 0;
    }

    function displayChargeItems(chargeItems, container) {
      if (!container || !chargeItems || chargeItems.length === 0) {
        if (container) container.innerHTML = '';
        return;
      }

      let chargeItemsHTML = '';
      chargeItems.forEach(chargeItem => {
        const isDiscount = chargeItemIsDiscount(chargeItem);
        const amount = Math.abs(parseMoney(chargeItem.amount || 0));
        chargeItemsHTML += `
          <div class="charge-item ${isDiscount ? 'discount-item' : ''}">
            <span class="charge-item-name">${escapeHTML(chargeItem.name || (isDiscount ? 'AD Discount' : 'Charge'))}</span>
            <span class="charge-item-amount">${isDiscount ? '-' : ''}₱ ${amount.toFixed(2)}</span>
          </div>
        `;
      });
      container.innerHTML = chargeItemsHTML;
    }

    function displayDiscountItems(discountItems, container) {
      displayChargeItems((discountItems || []).map(item => ({
        ...item,
        type: 'discount',
        amount: Math.abs(parseMoney(item.amount || 0))
      })), container);
    }

    function fetchAndDisplayADCharges(adId, container, chargesElement, subtotalAmount) {
      if (!adId || !container) return;

      fetch(`{{ url('/api/ad-charges') }}/${adId}`)
        .then(response => response.json())
        .then(data => {
          if (data.success && data.charges && data.charges.length > 0) {
            console.log('Fetched AD charges:', data.charges);
            displayChargeItems(data.charges, container);
            
            // Update the charges amount
            if (chargesElement) {
              chargesElement.textContent = '₱ ' + data.total.toFixed(2);
            }
            
            // Update the order total
            const newTotal = subtotalAmount + data.total;
            document.getElementById('order-total').textContent = '₱ ' + newTotal.toFixed(2);
            
            // Update orderData
            orderData.delivery_fee = data.total;
            orderData.other_charges = data.total;
            orderData.total_amount = newTotal;
          } else {
            console.log('No charges found for AD:', adId);
            container.innerHTML = '';
            // Hide the row if no charges
            const otherChargesRow = document.getElementById('other-charges-row');
            if (otherChargesRow) {
              otherChargesRow.style.setProperty('display', 'none', 'important');
            }
          }
        })
        .catch(error => {
          console.error('Error fetching AD charges:', error);
          container.innerHTML = '';
        });
    }

    function fetchAndDisplayADCharges(adId, container, chargesElement, subtotalAmount) {
      if (!adId || !container) return;

      fetch(`{{ url('/api/ad-charges') }}/${adId}`)
        .then(response => response.json())
        .then(data => {
          const fetchedCharges = data.charges || [];
          const fetchedDiscounts = data.discounts || [];

          if (data.success && (fetchedCharges.length > 0 || fetchedDiscounts.length > 0)) {
            const chargesTotal = parseMoney(data.charges_total ?? data.total);
            const discountTotal = parseMoney(data.discount_total);
            const netAdjustment = parseMoney(data.total);

            displayChargeItems(fetchedCharges, container);

            if (chargesElement) {
              chargesElement.textContent = '₱ ' + chargesTotal.toFixed(2);
            }

            const otherChargesRow = document.getElementById('other-charges-row');
            if (otherChargesRow) {
              otherChargesRow.style.setProperty('display', chargesTotal > 0 ? 'flex' : 'none', 'important');
            }

            const discountRow = document.getElementById('ad-discount-row');
            const discountElement = document.getElementById('ad-discount');
            const discountItemsList = document.getElementById('discount-items-list');
            if (discountRow) {
              discountRow.style.setProperty('display', discountTotal > 0 ? 'flex' : 'none', 'important');
            }
            if (discountElement) discountElement.textContent = '-₱ ' + discountTotal.toFixed(2);
            if (discountItemsList) displayDiscountItems(fetchedDiscounts, discountItemsList);

            const newTotal = subtotalAmount + netAdjustment;
            document.getElementById('order-total').textContent = '₱ ' + newTotal.toFixed(2);

            orderData.delivery_fee = netAdjustment;
            orderData.other_charges = netAdjustment;
            orderData.ad_charge_total = chargesTotal;
            orderData.discount_total = discountTotal;
            orderData.other_charge_items = [
              ...fetchedCharges,
              ...fetchedDiscounts.map(item => ({
                ...item,
                type: 'discount',
                amount: -Math.abs(parseMoney(item.amount || 0))
              }))
            ];
            orderData.other_charge_only_items = fetchedCharges;
            orderData.discount_items = fetchedDiscounts;
            orderData.total_amount = newTotal;
          } else {
            container.innerHTML = '';

            const discountRow = document.getElementById('ad-discount-row');
            const discountItemsList = document.getElementById('discount-items-list');
            if (discountRow) discountRow.style.setProperty('display', 'none', 'important');
            if (discountItemsList) discountItemsList.innerHTML = '';

            const otherChargesRow = document.getElementById('other-charges-row');
            if (otherChargesRow) {
              otherChargesRow.style.setProperty('display', 'none', 'important');
            }
          }
        })
        .catch(error => {
          console.error('Error fetching AD charges:', error);
          container.innerHTML = '';
        });
    }

    // function displayTransactionType() {
    //     const display = document.getElementById('payment-method-display');
    //     const label = document.getElementById('payment-method');

    //     if (orderData.transaction_type === 'ad_order') {
    //         const ad = adData || {};

    //         display.innerHTML = `
    //             <div class="payment-icon rounded-2 d-flex align-items-center justify-content-center flex-shrink-0" style="background:#fff3cd;">
    //                 <i class="bi bi-building"></i>
    //             </div>
    //             <div class="payment-details flex-grow-1">
    //                 <div class="payment-name fw-semibold">Order to Area Distributor</div>
    //                 <div class="payment-desc small text-muted">
    //                     ${ad.name || 'AD'} ${ad.area ? '• ' + ad.area : ''}
    //                 </div>
    //             </div>
    //         `;

    //         label.textContent = 'AD Order';
    //     } else {
    //         label.textContent = 'Client Order';
    //     }
    // }

    function updatePaymentMethodDisplay(method) {
      const display = document.getElementById('payment-method-display');
      const paymentMethodText = document.getElementById('payment-method');

      if (method === 'gcash') {
        display.innerHTML = `
          <div class="payment-icon gcash rounded-2 d-flex align-items-center justify-content-center flex-shrink-0">
            <i class="bi bi-phone-fill"></i>
          </div>
          <div class="payment-details flex-grow-1">
            <div class="payment-name fw-semibold">GCash Payment</div>
            <div class="payment-desc small text-muted">Payment completed via GCash</div>
          </div>
        `;
        paymentMethodText.textContent = 'GCash';
      } else if (method === 'credit') {
        display.innerHTML = `
          <div class="payment-icon credit rounded-2 d-flex align-items-center justify-content-center flex-shrink-0">
            <i class="bi bi-collection"></i>
          </div>
          <div class="payment-details flex-grow-1">
            <div class="payment-name fw-semibold">Credit Payment</div>
            <div class="payment-desc small text-muted">Payment will be settled later</div>
          </div>
        `;
        paymentMethodText.textContent = 'Credit';
      } else if (method === 'bank_transfer') {
        display.innerHTML = `
          <div class="payment-icon bank_transfer rounded-2 d-flex align-items-center justify-content-center flex-shrink-0">
            <i class="bi bi-bank"></i>
          </div>
          <div class="payment-details flex-grow-1">
            <div class="payment-name fw-semibold">Bank Transfer</div>
            <div class="payment-desc small text-muted">Settle payment via bank deposit or transfer</div>
          </div>
        `;
        paymentMethodText.textContent = 'Bank Transfer';
      } else {
        display.innerHTML = `
          <div class="payment-icon cod rounded-2 d-flex align-items-center justify-content-center flex-shrink-0">
            <i class="bi bi-cash-coin"></i>
          </div>
          <div class="payment-details flex-grow-1">
            <div class="payment-name fw-semibold">Cash on Delivery</div>
            <div class="payment-desc small text-muted">Customer pays upon delivery</div>
          </div>
        `;
        paymentMethodText.textContent = 'Cash on Delivery';
      }
    }

    function updateDeliveryMethodDisplay(method) {
        const deliveryMethodText = document.getElementById('delivery-method');
        if (!deliveryMethodText) return;

        if (method === 'delivery') {
            deliveryMethodText.textContent = 'Delivery';
        } else {
            deliveryMethodText.textContent = 'Pickup';
        }
    }

    function displayOrderItems() {
        const container = document.getElementById('order-items-list');
        let itemsHTML = '';
        
        dealerCartData.forEach(item => {
            const itemTotal = item.price * item.quantity;
            let colorInfo = '';
            
            if (item.color) {
                colorInfo = ` (${item.color.charAt(0).toUpperCase() + item.color.slice(1)})`;
            }
            
            itemsHTML += `
                <div class="order-item">
                    <div class="quantity-item">${item.quantity}</div>
                    <div class="item-info">
                        <div class="item-name">${item.originalName || item.name}${colorInfo}</div>
                        <div class="item-details">₱${item.price.toFixed(2)}</div>
                    </div>
                    <div class="item-total">₱${itemTotal.toFixed(2)}</div>
                </div>
            `;
        });
        
        container.innerHTML = itemsHTML;
    }

    // async function saveTransactionsToDatabase() {
    //     try {
    //         const isADOrder = orderData.transaction_type === 'ad_order';

    //         const customerId = !isADOrder 
    //             ? (customerData?.id || localStorage.getItem('selectedCustomerId'))
    //             : null;

    //         const adId = isADOrder 
    //             ? (adData?.id)
    //             : null;

    //         // ✅ Now it's safe to use
    //         console.log('Customer ID:', customerId);
    //         console.log('AD ID:', adId);
    //         console.log('Customer Data:', customerData);
    //         console.log('Cart Items:', dealerCartData);

    //         let csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
            
    //         if (!csrfToken) {
    //             const tokenInput = document.querySelector('input[name="_token"]');
    //             csrfToken = tokenInput ? tokenInput.value : null;
    //         }
            
    //         console.log('CSRF Token:', csrfToken ? 'Found' : 'Not Found');
            
    //         if (!csrfToken) {
    //             throw new Error('CSRF token not found. Please refresh the page.');
    //         }

    //         let successCount = 0;
    //         let failedItems = [];

    //         for (let i = 0; i < dealerCartData.length; i++) {
    //             const item = dealerCartData[i];
                
    //             try {
    //                 console.log(`Saving item ${i + 1}/${dealerCartData.length}:`, item);
                    
    //                 const formData = new FormData();
    //                 formData.append('item_id', item.id);
    //                 formData.append('qty', item.quantity);

    //                 if (customerId) {
    //                     formData.append('customer_id', customerId);
    //                 }

    //                 if (adId) {
    //                     formData.append('area_distributor_id', adId);
    //                 }
    //                 // formData.append('customer_id', customerId);
    //                 // formData.append('_token', csrfToken);

    //                 const storeUrl = "{{ route('transactions.store') }}";
                    
    //                 console.log('Sending request to:', storeUrl);
    //                 console.log('FormData:', {
    //                     item_id: item.id,
    //                     qty: item.quantity,
    //                     customer_id: customerId
    //                 });
                    
    //                 const response = await fetch(storeUrl, {
    //                     method: 'POST',
    //                     body: formData,
    //                     headers: {
    //                         'X-Requested-With': 'XMLHttpRequest',
    //                         'Accept': 'application/json',
    //                         'X-CSRF-TOKEN': csrfToken
    //                     },
    //                     credentials: 'same-origin',
    //                     redirect: 'follow'
    //                 });

    //                 console.log(`Response status for item ${i + 1}:`, response.status);
                    
    //                 const responseText = await response.text();
                    
    //                 let responseData;
    //                 try {
    //                     responseData = JSON.parse(responseText);
    //                     console.log(`Response data for item ${i + 1}:`, responseData);
                        
    //                     if (responseData.errors) {
    //                         console.error('Validation errors:', responseData.errors);
    //                         console.error('Request data sent:', responseData.request_data);
    //                     }
    //                 } catch (parseError) {
    //                     console.error('Failed to parse JSON. Raw response:', responseText.substring(0, 1000));
                        
    //                     if (responseText.includes('login') || responseText.includes('Login') || response.status === 401) {
    //                         throw new Error('Session expired. Please login again.');
    //                     }
                        
    //                     if (responseText.includes('404') || responseText.includes('Not Found')) {
    //                         throw new Error('Route not found. Please check if the route exists in web.php');
    //                     }
                        
    //                     if (responseText.includes('<!DOCTYPE') || responseText.includes('<html')) {
    //                         throw new Error('Server returned HTML instead of JSON. Check server logs for details.');
    //                     }
                        
    //                     throw new Error('Server returned invalid response. Please check server logs.');
    //                 }

    //                 if (!response.ok) {
    //                     throw new Error(responseData.message || `HTTP ${response.status}: Failed to save item`);
    //                 }

    //                 if (responseData.success || response.status === 200) {
    //                     successCount++;
    //                     console.log(`Item ${i + 1} saved successfully`);
    //                 } else {
    //                     throw new Error(responseData.message || 'Unknown error occurred');
    //                 }

    //             } catch (itemError) {
    //                 console.error(`Error saving item ${i + 1}:`, itemError);
    //                 failedItems.push({
    //                     name: item.originalName || item.name,
    //                     error: itemError.message
    //                 });
    //             }
    //         }

    //         if (failedItems.length > 0) {
    //             const failedItemsList = failedItems.map(fi => `- ${fi.name}: ${fi.error}`).join('\n');
    //             throw new Error(`Failed to save some items:\n${failedItemsList}\n\nSaved: ${successCount}/${dealerCartData.length}`);
    //         }
            
    //         console.log(`All ${successCount} transactions saved successfully!`);
    //         return true;

    //     } catch (error) {
    //         console.error('Error in saveTransactionsToDatabase:', error);
    //         throw error;
    //     }
    // }

    async function saveTransactionsToDatabase() {
      try {
          const isADOrder = orderData.transaction_type === 'ad_order';

          const customerId = !isADOrder
              ? (customerData?.id || localStorage.getItem('selectedCustomerId'))
              : null;
          const clientTag = !isADOrder && ['guest', 'others'].includes(String(customerId))
              ? String(customerId)
              : null;

          const adId = isADOrder
              ? (adData?.id)
              : null;

          console.log('Customer ID:', customerId);
          console.log('AD ID:', adId);
          console.log('Transaction Type:', isADOrder ? 'AD ORDER' : 'CLIENT ORDER');

          // ✅ Choose correct route
          const storeUrl = isADOrder
              ? "{{ route('ad.transactions.store') }}"
              : "{{ route('transactions.store') }}";

          // ✅ CSRF Token
          let csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');

          if (!csrfToken) {
              const tokenInput = document.querySelector('input[name="_token"]');
              csrfToken = tokenInput ? tokenInput.value : null;
          }

          if (!csrfToken) {
              throw new Error('CSRF token not found. Please refresh the page.');
          }

          let successCount = 0;
          let failedItems = [];

          for (let i = 0; i < dealerCartData.length; i++) {
              const item = dealerCartData[i];

              try {
                  console.log(`Saving item ${i + 1}/${dealerCartData.length}:`, item);

                  const formData = new FormData();
                  formData.append('item_id', item.id);
                  formData.append('qty', item.quantity);

                  // ✅ Send only needed ID
                  // if (isADOrder && adId) {
                  //     formData.append('area_distributor_id', adId);
                  // }

                  // if (!isADOrder && customerId) {
                  //     formData.append('customer_id', customerId);
                  // }

                  if (isADOrder) {
                      formData.append('area_distributor_id', adId);
                  } else {
                      if (clientTag) {
                          formData.append('client_tag', clientTag);
                      } else {
                          formData.append('customer_id', customerId);
                      }
                  }

                  formData.append('payment_method', orderData.payment_method || 'cash');
                  formData.append('delivery_type', orderData.delivery_type || 'pickup');
                  formData.append('delivery_fee', orderData.delivery_fee || 0);
                  formData.append('other_charges', orderData.other_charges || 0);
                  
                  // Store individual charge items as JSON
                  if (orderData.other_charge_items && orderData.other_charge_items.length > 0) {
                      formData.append('other_charge_items', JSON.stringify(orderData.other_charge_items));
                  }

                  const response = await fetch(storeUrl, {
                      method: 'POST',
                      body: formData,
                      headers: {
                          'X-Requested-With': 'XMLHttpRequest',
                          'Accept': 'application/json',
                          'X-CSRF-TOKEN': csrfToken
                      },
                      credentials: 'same-origin'
                  });

                  const responseText = await response.text();

                  let responseData;
                  try {
                      responseData = JSON.parse(responseText);
                  } catch (e) {
                      console.error('Raw response:', responseText);

                      if (response.status === 401) {
                          throw new Error('Session expired. Please login again.');
                      }

                      throw new Error('Invalid server response.');
                  }

                  if (!response.ok) {
                      throw new Error(responseData.message || `HTTP ${response.status}`);
                  }

                  successCount++;
                  console.log(`✅ Item ${i + 1} saved`);

              } catch (itemError) {
                  console.error(`❌ Error saving item ${i + 1}:`, itemError);

                  failedItems.push({
                      name: item.originalName || item.name,
                      error: itemError.message
                  });
              }
          }

          if (failedItems.length > 0) {
              const failedItemsList = failedItems
                  .map(fi => `- ${fi.name}: ${fi.error}`)
                  .join('\n');

              throw new Error(
                  `Failed to save some items:\n${failedItemsList}\n\nSaved: ${successCount}/${dealerCartData.length}`
              );
          }

          console.log(`✅ All ${successCount} transactions saved successfully!`);
          return true;

      } catch (error) {
          console.error('Error in saveTransactionsToDatabase:', error);
          throw error;
      }
    }

    const completeOrderBtn = document.getElementById('complete-order-btn');
    
    completeOrderBtn.addEventListener('click', async function() {
        const paymentMethod = orderData.payment_method || 'cash';
        
        const isADOrder = orderData.transaction_type === 'ad_order';

        if (!isADOrder && !customerData?.id) {
            Swal.fire({
                title: 'Customer Not Selected',
                text: 'Please go back and select a customer before placing the order.',
                icon: 'warning',
                confirmButtonText: 'Go Back'
            }).then(() => {
                history.back();
            });
            return;
        }

        if (!dealerCartData || dealerCartData.length === 0) {
            Swal.fire({
                title: 'Cart is Empty',
                text: 'Please add items to your cart before placing the order.',
                icon: 'warning',
                confirmButtonText: 'Go Back'
            }).then(() => {
                history.back();
            });
            return;
        }
        
        this.disabled = true;
        this.innerHTML = '<i class="bi bi-hourglass-split"></i> <span>Processing...</span>';
        
        try {
            console.log('Starting order placement...');
            console.log('Customer:', customerData);
            
            await saveTransactionsToDatabase();
            
            console.log('All transactions saved, completing order...');
            
            setTimeout(() => {
                orderData.completed_at = new Date().toLocaleString('en-PH', {
                    year: 'numeric',
                    month: 'long', 
                    day: 'numeric',
                    hour: '2-digit',
                    minute: '2-digit',
                    hour12: true
                });
                orderData.status = 'completed';
                
                if (paymentMethod === 'cash') {
                    orderData.received_amount = orderData.total_amount;
                    orderData.change_amount = 0;
                }
                
                const completedOrders = JSON.parse(localStorage.getItem('completedOrders') || '[]');
                completedOrders.push(orderData);
                // localStorage.setItem('completedOrders', JSON.stringify(completedOrders));
                localStorage.setItem('completedOrders', JSON.stringify(completedOrders));
                if (orderData.transaction_type === 'ad_order') {
                    localStorage.setItem('lastADOrder', JSON.stringify(orderData.ad));
                }
                localStorage.removeItem('dealerCartData');
                localStorage.removeItem('dealerCartItems');
                localStorage.removeItem('orderData');
                localStorage.removeItem('dealerOrderData');
                localStorage.removeItem('cartTotal');
                localStorage.removeItem('cartItems');
                localStorage.removeItem('selectedCustomerId');
                localStorage.removeItem('selectedCustomerName');
                localStorage.removeItem('selectedCustomerSerial');
                localStorage.removeItem('selectedCustomerNumber');
                localStorage.removeItem('selectedCustomerFullName');

                window.matchedAD = JSON.parse(localStorage.getItem('selectedAD') || 'null');

                if (!orderData.ad && window.matchedAD) {
                    orderData.ad = window.matchedAD;
                }

                if (typeof updateCartBadge === 'function') updateCartBadge();
                if (typeof updateFloatingCartButton === 'function') updateFloatingCartButton();
                
                this.innerHTML = '<i class="bi bi-check-circle success-checkmark"></i> <span>Order Completed!</span>';
                
                Swal.fire({
                    title: 'Order Completed Successfully!',
                    html: `
                        <p>Order has been placed for <strong>
                          ${orderData.transaction_type === 'ad_order'
                              ? (adData?.name || 'Area Distributor')
                              : (customerData?.name || 'Customer')}
                          </strong></p>
                    `,
                    icon: 'success',
                    timer: 2500,
                    showConfirmButton: false,
                    timerProgressBar: true,
                    allowOutsideClick: false
                }).then(() => {
                    window.location.href = '{{url('/')}}';
                });
            }, 1000);

        } catch (error) {
            console.error('Failed to complete order:', error);
            
            this.disabled = false;
            this.innerHTML = '<i class="bi bi-check-circle"></i> <span>Place Order</span>';
            
            Swal.fire({
                title: 'Error',
                text: error.message || 'Failed to save order to database. Please try again.',
                icon: 'error',
                confirmButtonText: 'OK'
            });
        }
    });

    initializeOrderPage();
    completeOrderBtn.disabled = false;
});
</script>
@endsection
