@extends('admin.themes.layouts.main')

@section('title', 'POS - Receive')

@section('content')

<style>
    body {
        overflow-y: hidden;
    }

    .item-content {
        overflow-y: scroll !important;
    }

    .product-content {
        max-height: 400px;
        overflow-y: scroll !important;
    }

    .hover-box {
    transition: transform 0.3s ease-in-out, box-shadow 0.3s ease-in-out;
    }

    .hover-box:hover {
        transform: scale(1.05);
        box-shadow: 0px 4px 15px rgba(0, 0, 0, 0.2);
        cursor: pointer;
    }
</style>


<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Receive</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a
                            href="{{ action('App\Http\Controllers\AdminController@home') }}">Home</a></li>
                    <li class="breadcrumb-item">POS</li>
                    <li class="breadcrumb-item">Receive</li>
                </ol>
            </div>
        </div>
    </div>
</div>

{{-- Main Content --}}
<div class="content">

    <div class="row">
        <div class="col-md-8">
            <div class="container-fluid">
                <header>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="info-box bg-gradient-warning hover-box">
                                <span class="info-box-icon"><i class="fa fa-circle-info"></i></span>
                                <div class="info-box-content">
                                    <span class="info-box-text">Out of Stock</span>
                                    <span class="info-box-number">4 Items</span>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="info-box bg-gradient-warning hover-box">
                                <span class="info-box-icon"><i class="fa fa-box-open"></i></span>
                                <div class="info-box-content">
                                    <span class="info-box-text">Low on Stock</span>
                                    <span class="info-box-number">13 Items</span>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="info-box bg-gradient-info">
                                <span class="info-box-icon"><i class="fa fa-hashtag"></i></span>
                                <div class="info-box-content">
                                    <span class="info-box-text">Transaction Number</span>
                                    <span class="info-box-number">{{ getTransactionNumber() }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </header>

                <section>
                    <div class="row mb-3">
                        <div class="col-md-12">
                            <div class="d-flex align-items-center">
                                <label for="cat_id mt-1" style="flex-basis: 20%" class="">Categories: </label>
                                <select class="form-control" name="cat_id" id="cat_id">
                                    <option value="">-- ALL --</option>
                                    @foreach ($categories as $category)
                                    <option value="{{ $category->cat_name }}">{{ $category->cat_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12 product-content">
                            <table class="table table-striped table-hover" id="example2">
                                <thead>
                                    <tr>
                                        <th hidden></th>
                                        <th>SKU #</th>
                                        <th>Product Name</th>
                                        <th>Category</th>
                                        <th>Attribute</th>
                                        <th width="120px">Price</th>
                                        <th width="20px">Quantity</th>
                                        <th class="text-center">btn</th>
                                    </tr>
                                </thead>
                                <tbody class="">
                                    @foreach ($products as $product)
                                    <tr>
                                        <form method="post"
                                            action="{{ action('App\Http\Controllers\POSController@pos_purchase_add') }}"
                                            class="{{ $product->prd_id }}">
                                            @csrf
                                            <td hidden>
                                                <input type="hidden" name="item_prd_id" id="item_prd_id"
                                                    value="{{ $product->prd_id }}">
                                            </td>
                                            <td>{{ $product->prd_sku_number }}</td>
                                            <td>{{ $product->prd_name }}</td>
                                            <td>{{ $product->category_name }}</td>
                                            <td>{{ $product->category_value ?? 'N/A' }}</td>
                                            @php
                                            $price_type = DB::table('price_type')
                                            ->where('prd_id', '=', $product->prd_id)
                                            ->first();
                                            @endphp
                                            <td width="120px">
                                                <select class="form-control" name="item_price" id="item_price">
                                                    <option value="{{ $price_type->price_typ_retail }}">Retail: {{
                                                        number_format($price_type->price_typ_retail) }}</option>
                                                    <option value="{{ $price_type->price_typ_dealer }}">Dealer: {{
                                                        number_format($price_type->price_typ_dealer) }}</option>
                                                </select>
                                            </td>
                                            <td width="20px">
                                                <input class="form-control" type="number" name="item_quantity"
                                                    id="item_quantity" step="1" max="50" placeholder="0" required>
                                            </td>
                                            <td class="text-center">
                                                <button type="submit" class="btn btn-sm btn-primary button-item-add">
                                                    <i class="fa-solid fa-plus"></i>
                                                </button>
                                            </td>
                                        </form>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </section>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card my-0 py-0" style="min-height: 555px; max-height: 560px">
                
                <div class="card-body item-content pt-1">
                    <form method="POST" action="{{ action('App\Http\Controllers\POSController@pos_purchase_add_transaction') }}">
                        @csrf
                        <div class="header my-0 pt-0 pb-0 border-bottom">
                            <div class="d-flex align-items-center pb-0 mb-1 mt-0">
                                <label for="clt_id" class="form-label mx-auto mt-1" style="flex-basis: 50%">Select
                                    Client:</label>
                                <select class="form-control mx-auto" name="clt_id" id="clt_id" required>
                                    <option value="">--Select Client--</option>
                                    @foreach ($clients as $client)
                                    <option value="{{ $client->clt_id }}">{{ $client->clt_name }}</option>
                                    @endforeach
                                </select>
                                <button class="btn btn-primary ml-auto"><i class="fa-solid fa-circle-plus"></i></button>
                            </div>
                        </div>
                        
                        <label for="">Selected Items:</label>
                        <ul>
                            @if ($temp_items->count() > 0)
                                @foreach ($temp_items as $temp_item)
                                    <li class="ml-0 pl-0 " style="list-style: none">
                                        <div class="info-box">
                                            <div class="info-box-content">
                                                <span class="info-box-text">{{ $temp_item->prd_name }} - {{ $temp_item->cat_name }} - {{ $temp_item->pcv_value }}</span>
                                                <div class="row">
                                                    <div class="col-md-2">
                                                        <label for="po_product_price">Price:</label>
                                                    </div>
                                                    <div class="col-md-5">
                                                        <input type="number" class="form-control form-control-border form-control-sm" name="products[{{ $temp_item->prd_id }}][po_product_price]" id="po_product_price" value="{{ $temp_item->tpo_prd_price }}" readonly required>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <input type="number" class="form-control form-control-border form-control-sm" name="products[{{ $temp_item->prd_id }}][po_prd_quantity]" id="po_prd_quantity"
                                                            value="{{ $temp_item->tpo_quantity }}" data-price="{{ $temp_item->tpo_prd_price }}" required>
                                                    </div>
                                                    <div class="col-md-2">
                                                        <label for="po_prd_quantity">pcs.</label>
                                                    </div>
                                                    <div class="col-md-2">
                                                        <label for="po_total_amount">Total:</label>
                                                    </div>
                                                    <div class="col-md-5">
                                                        <input type="number" class="form-control form-control-border form-control-sm" name="products[{{ $temp_item->prd_id }}][po_total_amount]" id="po_total_amount" value="{{ $temp_item->tpo_total_price }}" readonly required>
                                                    </div>
                                                    <div class="col-md-5">
                                                        <input type="hidden" name="products[{{ $temp_item->prd_id }}][prd_id]" id="prd_id" value="{{ $temp_item->prd_id }}" readonly>
                                                        <button class="btn btn-sm btn-danger mb-0 pb-0 mt-1" style="width: 100%" type="button"><i class="fa fa-trash" aria-hidden="true"></i></button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </li>
                                @endforeach
                            @else
                                <p class="text-center">No item Selected</p>
                            @endif
                        </ul>
                    </div>
                    <div class="card-footer">
                        <div class="row">
                            <div class="col-md-2">
                                <label for="">Total:</label>
                            </div>
                            <div class="col-md-5">
                                <input type="number" class="form-control form-control-sm" name="grand_total" id="grand_total">
                            </div>

                            <div class="col-md-3">
                                <input type="number" class="form-control form-control-sm" name="total_quantity" id="total_quantity">
                            </div>
                            <div class="col-md-2">
                                <label for="">pcs.</label>
                            </div>
                            
                            <div class="col-md-12 mt-2">
                                <button class="btn btn-sm btn-success" type="submit" style="width: 100%"
                                    @if ($temp_items->count() == 0)
                                        disabled
                                    @endif
                                >Save</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    document.getElementById('cat_id').addEventListener('change', function() {
        let selectedCategory = this.value;
        let tableRows = document.querySelectorAll('tbody tr');

        tableRows.forEach(row => {
            let categoryCell = row.cells[3]; // The category is in the third cell
            let categoryValue = categoryCell.textContent.trim();

            if (selectedCategory === "" || categoryValue === selectedCategory) {
                row.style.display = ""; // Show row
            } else {
                row.style.display = "none"; // Hide row
            }
        });
    });

    document.addEventListener('DOMContentLoaded', function () {

        updateGrandTotal();

        document.querySelectorAll('[id="po_prd_quantity"]').forEach(function(quantityInput) {
            quantityInput.addEventListener('input', function() {
                const price = parseFloat(this.dataset.price);
                const quantity = parseFloat(this.value);
                const totalAmount = price * quantity;

                const totalAmountField = this.closest('.row').querySelector('[id="po_total_amount"]');
                totalAmountField.value = totalAmount.toFixed(2);
                
                updateGrandTotal();
            });
        });
    });

    function updateGrandTotal() {
        let grandTotal = 0;
        let totalQuantity = 0;
        
        document.querySelectorAll('#po_total_amount').forEach(input => {
            grandTotal += parseFloat(input.value);
        });

        document.querySelectorAll('#po_prd_quantity').forEach(input => {
            totalQuantity += parseInt(input.value);
        });

        document.getElementById('grand_total').value = grandTotal.toFixed(2);
        document.getElementById('total_quantity').value = totalQuantity;
    }

    // $('#cat_id').on('change', function() {
    //     var selectedCategory = $(this).val();
    //     $('tbody tr').each(function() {
    //         var category = $(this).find('td:nth-child(3)').text().trim();
    //         if (selectedCategory === "" || category === selectedCategory) {
    //             $(this).show();
    //         } else {
    //             $(this).hide();
    //         }
    //     });
    // });

    // $(document).ready(function() {
    //     // Attach event listener to the plus button
    //     $('tbody').on('click', '.button-item-add', function(e) {
    //         e.preventDefault();  // Prevent page reload
            
    //         // Extract product details from the current row
    //         var $row = $(this).closest('tr');
    //         var sku = $row.find('td').eq(1).text();
    //         var name = $row.find('td').eq(2).text();
    //         var price = $row.find('input').eq(0).val();
    //         var quantity = $row.find('input').eq(1).val();

    //         // Create a new item element
    //         var newItem = `
    //             <div class="d-flex justify-content-between align-items-center my-2">
    //                 <div>
    //                     <strong>${name}</strong> (SKU: ${sku})
    //                     <br>
    //                     Quantity: ${quantity}, Price: ${price}
    //                 </div>
    //                 <button class="btn btn-danger btn-sm remove-item"><i class="fa-solid fa-trash"></i></button>
    //             </div>
    //         `;

    //         // Append the new item to the .item-content div
    //         $('.item-content').append(newItem);

    //         // Optionally, you can remove the "No item Selected" text if there's any item added
    //         $('.item-content p').remove();
    //     });

    //     // Remove item when trash button is clicked
    //     $('.item-content').on('click', '.remove-item', function(e) {
    //         $(this).closest('div').remove();
            
    //         // If no items are left, display "No item Selected"
    //         if ($('.item-content').children().length === 0) {
    //             $('.item-content').html('<p class="text-center">No item Selected</p>');
    //         }
    //     });
    // });

    // $(document).ready(function() {
    //     // Attach event listener to the plus button
    //     $('tbody').on('click', '.button-item-add', function(e) {
    //         e.preventDefault();  // Prevent default button action
            
    //         // Find the form within the same row as the clicked button
    //         var $form = $(this).closest('tr').find('form');
            
    //         // Submit the form
    //         $form.submit();
    //     });
    // });
</script>

@endsection