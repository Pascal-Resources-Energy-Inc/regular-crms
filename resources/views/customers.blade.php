@extends('layouts.header')
<link rel="icon" type="image/png" href="{{asset('images/logo_nya.png')}}">
@section('css')

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/chosen/1.8.7/chosen.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/1.10.25/css/dataTables.bootstrap4.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.1/css/buttons.bootstrap4.min.css">

<style>
.customers-page {
  padding: 24px;
}

.customers-shell {
  background: #ffffff;
  border: 1px solid #e9eef5;
  border-radius: 8px;
  box-shadow: 0 10px 30px rgba(15, 23, 42, 0.06);
  overflow: hidden;
}

.customers-header {
  display: flex;
  align-items: center;
  justify-content: space-between;
  gap: 16px;
  padding: 22px 24px;
  border-bottom: 1px solid #eef2f7;
  background: #fbfcfe;
}

.customers-heading {
  min-width: 220px;
}

.customers-title {
  margin: 0;
  color: #162033;
  font-size: 22px;
  font-weight: 700;
}

.customers-subtitle {
  margin: 4px 0 0;
  color: #64748b;
  font-size: 13px;
}

.customers-actions {
  display: flex;
  align-items: center;
  gap: 10px;
  flex-wrap: wrap;
  justify-content: flex-end;
}

.customers-search {
  position: relative;
  width: min(360px, 42vw);
}

.customers-search > i {
  color: #94a3b8;
  left: 14px;
  pointer-events: none;
  position: absolute;
  top: 50%;
  transform: translateY(-50%);
}

.customers-search input {
  background: #ffffff;
  border: 1px solid #dbe3ef;
  border-radius: 6px;
  color: #334155;
  font-size: 14px;
  height: 40px;
  padding: 9px 38px 9px 38px;
  width: 100%;
}

.customers-search input:focus {
  border-color: #0f5fb8;
  box-shadow: 0 0 0 .18rem rgba(15, 95, 184, .12);
  outline: 0;
}

.customers-search-clear {
  align-items: center;
  background: transparent;
  border: 0;
  color: #94a3b8;
  display: none;
  height: 30px;
  justify-content: center;
  padding: 0;
  position: absolute;
  right: 7px;
  top: 5px;
  width: 30px;
}

.customers-search-clear:hover {
  color: #475569;
}

.customers-search-clear.is-visible {
  display: inline-flex;
}

.customers-meta {
  align-items: center;
  display: flex;
  gap: 10px;
  padding: 0 0 14px;
}

.customers-pill {
  align-items: center;
  background: #f1f7ff;
  border: 1px solid #d9eaff;
  border-radius: 999px;
  color: #0f5fb8;
  display: inline-flex;
  font-size: 12px;
  font-weight: 700;
  gap: 6px;
  padding: 7px 11px;
}

.customer-add-btn,
.customer-export-btn {
  display: inline-flex;
  align-items: center;
  gap: 7px;
  border-radius: 6px;
  font-weight: 600;
  min-height: 38px;
}

.customer-add-btn {
  background: #198754;
  border-color: #198754;
}

.customers-table-wrap {
  padding: 18px 20px 22px;
}

.customers-table {
  margin-bottom: 0 !important;
  border-color: #edf2f7 !important;
}

.customers-table thead th {
  background: #f8fafc;
  border-bottom: 1px solid #e2e8f0 !important;
  color: #475569;
  font-size: 12px;
  font-weight: 700;
  letter-spacing: .02em;
  text-transform: uppercase;
  white-space: nowrap;
}

.customers-table tbody td {
  color: #334155;
  font-size: 14px;
  vertical-align: middle;
}

.customers-table tbody tr:hover {
  background: #f8fbff;
}

.customer-name-link {
  color: #0f5fb8;
  font-weight: 700;
  text-decoration: none;
}

.customer-name-link:hover {
  color: #0a3f7a;
  text-decoration: underline;
}

.customer-empty-text {
  color: #94a3b8;
  font-style: italic;
}

.chosen-container .chosen-single {
  height: calc(2.25rem + 2px);
  padding: 0.375rem 0.75rem;
  font-size: 1rem;
  line-height: 1.5;
  color: #495057;
  background-color: #fff;
  border: 1px solid #ced4da;
  border-radius: 0.25rem;
  box-shadow: none;
}

.chosen-container-active.chosen-with-drop .chosen-single {
  border-color: #80bdff;
  box-shadow: 0 0 0 0.2rem rgba(0,123,255,.25);
}

.chosen-container .chosen-drop {
  border: 1px solid #ced4da;
  border-top: none;
  border-radius: 0 0 0.25rem 0.25rem;
  box-shadow: 0 0.5rem 1rem rgba(0,0,0,.15);
}

.chosen-container .chosen-results {
  max-height: 200px;
  overflow-y: auto;
}

.chosen-container .chosen-search input {
  height: calc(1.5em + 0.75rem + 2px);
  padding: 0.375rem 0.75rem;
  font-size: 1rem;
  border: 1px solid #ced4da;
  border-radius: 0.25rem;
}

.dataTables_wrapper .row:first-child {
  align-items: center;
  row-gap: 12px;
  margin-bottom: 14px;
}

.dataTables_wrapper .dt-buttons {
  margin-bottom: 0;
}

.dataTables_wrapper .dataTables_length label {
  color: #64748b;
  font-size: 13px;
  font-weight: 600;
  margin-bottom: 0;
}

.dataTables_wrapper .dataTables_length select {
  border: 1px solid #dbe3ef;
  border-radius: 6px;
  box-shadow: none;
}

.dataTables_wrapper .dataTables_info {
  color: #64748b;
  font-size: 13px;
  padding-top: 16px;
}

.dataTables_wrapper .pagination {
  justify-content: flex-end;
  margin-top: 12px;
  margin-bottom: 0;
}

.dataTables_wrapper .page-link {
  border-color: #dbe3ef;
  color: #475569;
  font-size: 13px;
  min-width: 36px;
  text-align: center;
}

.dataTables_wrapper .page-item.active .page-link {
  background: #0f5fb8;
  border-color: #0f5fb8;
}

@media (max-width: 767.98px) {
  .customers-page {
    padding: 12px;
  }

  .customers-header {
    align-items: flex-start;
    flex-direction: column;
    padding: 18px;
  }

  .customers-actions,
  .customers-search,
  .customer-add-btn,
  .customer-export-btn {
    width: 100%;
  }

  .customer-add-btn,
  .customer-export-btn {
    justify-content: center;
  }

}

</style>

@endsection
@section('content')
<section class="welcome customers-page">
    <div class="row">
        <div class="col-lg-12 col-xl-12 d-flex align-items-stretch">
            <div class="customers-shell w-100">
                <div class="customers-header">
                    <div class="customers-heading">
                        <h5 class="customers-title">Customers</h5>
                        <p class="customers-subtitle">Manage customer records, contact details, and latest transaction activity.</p>
                    </div>
                    <div class="customers-actions">
                        <div class="customers-search">
                            <i class="bi bi-search"></i>
                            <input type="search" id="customerSearch" placeholder="Search name, phone, email, address...">
                            <button type="button" class="customers-search-clear" id="clearCustomerSearch" aria-label="Clear search">
                                <i class="bi bi-x-lg"></i>
                            </button>
                        </div>
                        <div id="exportExcelContainer"></div>
                        <button class="btn btn-success customer-add-btn" data-bs-toggle="modal" data-bs-target="#new_customer">
                            <i class="bi bi-plus-lg"></i>
                            <span>Add Customer</span>
                        </button>
                    </div>
                </div>
                <div class="customers-table-wrap">
                  <div class="customers-meta">
                    <span class="customers-pill">
                      <i class="bi bi-people"></i>
                      {{ $customers->count() }} Total Customers
                    </span>
                    <span class="customers-pill">
                      <i class="bi bi-table"></i>
                      Paginated List
                    </span>
                  </div>
                  <div class="table-responsive">
                    <table id="example" class="table table-hover customers-table" style="width:100%">
                        <thead>
                          <tr>
                              <th>Customer Name</th>
                              <th>Contact Number</th>
                              <th>Email Address</th>
                              <th style="display:none;">Date Start</th>
                              <th style="display:none;">As of Now</th>
                              {{-- <th>Serial Number</th> --}}
                              <th>Address</th>
                              {{-- <th>Total Points</th> --}}
                              <th>Last Transaction</th>
                              <th style="display:none;">Remarks</th>
                              <th style="display:none;">Status</th>
                          </tr>
                        </thead>
                        <tbody id="customerBody">
                            @foreach($customers as $customer)
                          <tr>
                              <td><a class="customer-name-link" href='view-client/{{$customer->id}}'>{{ strtoupper($customer->name) }}</a></td>
                              <td>{{ $customer->number ?: 'No Data' }}</td>
                              <td>{{ $customer->email_address ?: 'No Data' }}</td>
                              <td style="display:none;">
                                  @php
                                      $firstTransaction = $customer->transactions->sortBy('date')->first();
                                  @endphp

                                  {{ $firstTransaction ? date('M d, Y', strtotime($firstTransaction->date)) : 'No Data' }}
                              </td>
                              <td style="display:none;">
                                  {{ \Carbon\Carbon::now()->format('M d, Y') }}
                              </td>
                              {{-- <td>
                                  @if($customer->serial)
                                      {{ $customer->serial->serial_number }}
                                  @endif
                              </td> --}}
                              <td>{{ $customer->address ?: 'No Data' }}</td>
                              {{-- <td>{{ $customer->transactions->sum('points_client') }}</td> --}}
                              <td>
                                  @php
                                      $transaction = ($customer->transactions)->sortByDesc('date')->first();
                                  @endphp
                                  @if($transaction)
                                      {{ date('M d, Y', strtotime($transaction->date)) }}
                                  @else
                                      <span class="customer-empty-text">No Data</span>
                                  @endif
                              </td>
                             
                              <td style="display:none;">@if($customer->serial && !empty($customer->serial->remarks)) SN# @if($customer->serial) {{ $customer->serial->serial_number }} @endif used to be owned by @if($customer->serial && $customer->serial->remarks) @php $previousOwner = \App\Client::find($customer->serial->remarks); @endphp {{ $previousOwner ? $previousOwner->name : 'Unknown Client' }} @endif  @endif</td>
                              <td style="display:none;">{{ $customer->status ?? '' }}</td>
                          </tr>
                          @endforeach

                        </tbody>
                    </table>
                  </div>
                </div>
            </div>
        </div>
    </div>
    
</section>
@endsection
@include('new_customer')
@section('javascript')
<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/chosen/1.8.7/chosen.jquery.min.js"></script>
<script src="https://cdn.datatables.net/1.10.25/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.10.25/js/dataTables.bootstrap4.min.js"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>

<!-- Buttons extension -->
<script src="https://cdn.datatables.net/buttons/2.4.1/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.bootstrap4.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.html5.min.js"></script>
<script>
$(document).ready(function() {
  $.fn.dataTable.ext.search.push(function(settings, data) {
    if (settings.nTable.id !== 'example') {
      return true;
    }

    return (data[7] || '').trim() !== 'Inactive';
  });

  var table = $('#example').DataTable({
    dom: '<"row"<"col-sm-12 col-md-6"l><"col-sm-12 col-md-6 text-md-end">>' +
         '<"row"<"col-sm-12"tr>>' +
         '<"row"<"col-sm-12 col-md-5"i><"col-sm-12 col-md-7"p>>',
    
    pageLength: 25,
    lengthMenu: [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]],
    order: [[0, 'asc']],
    pagingType: 'simple_numbers',
    language: {
      search: '',
      searchPlaceholder: 'Search customers...',
      lengthMenu: 'Show _MENU_ customers',
      info: 'Showing _START_ to _END_ of _TOTAL_ customers',
      infoEmpty: 'No active customers found',
      infoFiltered: '(filtered from _MAX_ total)',
      paginate: {
        previous: '<i class="bi bi-chevron-left"></i>',
        next: '<i class="bi bi-chevron-right"></i>'
      }
    },
    columnDefs: [
      { targets: [3, 4, 7], visible: false },
    ],
    
    buttons: [
      {
        extend: 'excelHtml5',
        text: '<i class="bi bi-file-earmark-excel"></i><span>Export Excel</span>',
        className: 'btn btn-outline-success customer-export-btn',
        title: 'Customers',
        exportOptions: {
          columns: [0, 1, 2, 3, 4, 5, 6, 7],
          modifier: {
            search: 'applied',
            order: 'current',
            page: 'all'
          },
          rows: function (idx, data, node) {
            return true;
          }
        }
      }
    ],
  });

  table.buttons().container().appendTo('#exportExcelContainer');

  $('#customerSearch').on('keyup search input', function() {
    table.search(this.value).draw();
    $('#clearCustomerSearch').toggleClass('is-visible', this.value.length > 0);
  });

  $('#clearCustomerSearch').on('click', function() {
    $('#customerSearch').val('').trigger('input').focus();
  });
});
</script>
<script>
  $(document).ready(function(){
    $('.chosen-select').chosen({
      width: '100%'
    });
  });
</script>
@endsection
