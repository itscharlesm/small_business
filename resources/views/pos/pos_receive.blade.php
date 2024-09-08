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
                                <label for="mcat_id mt-1" style="flex-basis: 20%" class="">Categories: </label>
                                <select class="form-control" name="mcat_id" id="mcat_id">
                                    <option value="">-- ALL --</option>
                                    @foreach ($categories as $category)
                                        <option value="{{ $category->mcat_name }}">{{ $category->mcat_name }}</option>
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
                                        <th>Menu Name</th>
                                        <th>Category</th>
                                        <th width="120px">Price</th>
                                        <th width="20px">Quantity</th>
                                        <th class="text-center">btn</th>
                                    </tr>
                                </thead>
                                <tbody class="">
                                    @foreach ($menus as $menu)
                                        <tr>
                                            <form method="post"
                                                action="{{ action('App\Http\Controllers\POSController@pos_purchase_add') }}"
                                                class="{{ $menu->menu_id }}">
                                                @csrf
                                                <td hidden>
                                                    <input type="hidden" name="item_prd_id" id="item_prd_id"
                                                        value="{{ $menu->menu_id }}">
                                                </td>
                                                <td>{{ $menu->menu_name }}</td>
                                                <td>{{ $menu->mcat_name }}</td>
                                                <td width="120px">{{ $menu->menu_price }}</td>
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
                    <form method="POST" action="">
                        @csrf
                        <hr>
                        <label for="">Orders:</label>
                        <hr>
                        <ul>
                                    <li class="ml-0 pl-0 " style="list-style: none">
                                        <div class="info-box">
                                            <div class="info-box-content">
                                                <span class="info-box-text">{{ $menu->menu_name }} - {{ $menu->mcat_name }}</span>
                                                <div class="row">
                                                    <div class="col-md-2">
                                                        <label for="po_product_price">Price:</label>
                                                    </div>
                                                    <div class="col-md-5">
                                                        <input type="number" class="form-control form-control-border form-control-sm" id="po_product_price" value="" readonly required>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <input type="number" class="form-control form-control-border form-control-sm" id="po_prd_quantity"
                                                            value="" data-price="" required>
                                                    </div>
                                                    <div class="col-md-2">
                                                        <label for="po_prd_quantity">orders</label>
                                                    </div>
                                                    <div class="col-md-2">
                                                        <label for="po_total_amount">Total:</label>
                                                    </div>
                                                    <div class="col-md-5">
                                                        <input type="number" class="form-control form-control-border form-control-sm" id="po_total_amount" value="" readonly required>
                                                    </div>
                                                    <div class="col-md-5">
                                                        <input type="hidden" id="prd_id" value="" readonly>
                                                        <button class="btn btn-sm btn-danger mb-0 pb-0 mt-1" style="width: 100%" type="button"><i class="fa fa-trash" aria-hidden="true"></i></button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </li>
                                <p class="text-center">No item Selected</p>
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
    document.getElementById('mcat_id').addEventListener('change', function() {
        let selectedCategory = this.value;
        let tableRows = document.querySelectorAll('tbody tr');

        tableRows.forEach(row => {
            let categoryCell = row.cells[2]; // The category is in the third cell
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
            
            if (!isNaN(price) && !isNaN(quantity)) {
                const totalAmount = price * quantity;
                const totalAmountField = this.closest('.row').querySelector('[id="po_total_amount"]');
                totalAmountField.value = totalAmount.toFixed(2);
                updateGrandTotal();
            }
        });
    });
});

function updateGrandTotal() {
    let grandTotal = 0;
    let totalQuantity = 0;

    document.querySelectorAll('#po_total_amount').forEach(input => {
        const value = parseFloat(input.value);
        if (!isNaN(value)) {
            grandTotal += value;
        }
    });

    document.querySelectorAll('#po_prd_quantity').forEach(input => {
        const quantity = parseInt(input.value);
        if (!isNaN(quantity)) {
            totalQuantity += quantity;
        }
    });

    const grandTotalInput = document.getElementById('grand_total');
    const totalQuantityInput = document.getElementById('total_quantity');

    if (grandTotalInput && totalQuantityInput) {
        grandTotalInput.value = grandTotal.toFixed(2);
        totalQuantityInput.value = totalQuantity;

        toggleSubmitButton(totalQuantity > 0);
    }
}

function toggleSubmitButton(enable) {
    const submitButton = document.querySelector('button[type="submit"]');
    if (submitButton) {
        submitButton.disabled = !enable;
    }
}

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