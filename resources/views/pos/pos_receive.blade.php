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
                <h1 class="m-0">Orders</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a
                            href="{{ action('App\Http\Controllers\AdminController@home') }}">Home</a></li>
                    <li class="breadcrumb-item">POS</li>
                    <li class="breadcrumb-item">Orders</li>
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
                                <span class="info-box-icon"><i class="fa fa-peso-sign"></i></span>
                                <div class="info-box-content">
                                    <span class="info-box-text">Transactions Today</span>
                                    <span class="info-box-number">5 Transactions</span>
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
                                        <th style="text-align: center">Menu Name</th>
                                        <th style="text-align: center">Category</th>
                                        <th style="text-align: center" width="120px">Price</th>
                                        <th style="text-align: center" width="20px">Quantity</th>
                                        <th style="text-align: center" class="text-center">Add</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($menus as $menu)
                                        <tr>
                                            <td style="vertical-align: middle">{{ $menu->menu_name }}</td>
                                            <td style="vertical-align: middle">{{ $menu->mcat_name }}</td>
                                            <td style="vertical-align: middle" width="120px">{{ $menu->menu_price }}</td>
                                            <td style="vertical-align: middle" width="20px">
                                                <input class="form-control item-quantity" type="number" step="1" max="50"
                                                    placeholder="0" data-price="{{ $menu->menu_price }}" required>
                                            </td>
                                            <td style="vertical-align: middle" class="text-center">
                                                <button type="button" class="btn btn-sm btn-primary button-item-add"
                                                    onclick="addItemToOrder('{{ $menu->menu_name }}', '{{ $menu->mcat_name }}', '{{ $menu->menu_price }}')">
                                                    <i class="fa fa-plus"></i>
                                                </button>
                                            </td>
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
                            <p class="text-center">No item Selected</p>
                        </ul>
                    </form>
                </div>
                <div class="card-footer">
                    <div class="row">
                        <div class="col-md-2">
                            <label for="">Total:</label>
                        </div>
                        <div class="col-md-5">
                            <input type="number" class="form-control form-control-sm" name="mtrx_total" id="mtrx_total"
                                readonly>
                        </div>

                        <div class="col-md-3">
                            <input type="number" class="form-control form-control-sm" name="mtrx_total_orders"
                                id="mtrx_total_orders" readonly>
                        </div>
                        <div class="col-md-2">
                            <label for="">orders</label>
                        </div>

                        <div class="col-md-12 mt-2">
                            <button class="btn btn-sm btn-success" type="submit" style="width: 100%">Save</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    // Order Script
    document.addEventListener('DOMContentLoaded', function () {
        function updateOrderList(menu_name, itemPrice, mcat_name, quantity) {
            const orderList = document.querySelector('.item-content ul');
            const noItemMessage = document.querySelector('.item-content ul p');

            if (!orderList) {
                console.error('Order list element not found.');
                return;
            }

            let item = Array.from(orderList.children).find(li => {
                const textElement = li.querySelector('.info-box-text');
                return textElement && textElement.textContent.includes(menu_name);
            });

            if (item) {
                const quantityInput = item.querySelector('#trx_order_quantity');
                const priceInput = item.querySelector('#trx_order_price');
                const totalInput = item.querySelector('#trx_total_amount');

                if (quantityInput && priceInput && totalInput) {
                    quantityInput.value = parseInt(quantityInput.value) + parseInt(quantity);
                    totalInput.value = quantityInput.value * priceInput.value;
                    quantityInput.dispatchEvent(new Event('input')); // Trigger the input event to recalculate totals
                } else {
                    console.error('Quantity, Price, or Total input not found.');
                }
            } else {
                const newItem = document.createElement('li');
                newItem.className = 'ml-0 pl-0';
                newItem.style.listStyle = 'none';

                newItem.innerHTML = `
            <div class="info-box">
                <div class="info-box-content">
                    <span class="info-box-text">${menu_name} - ${mcat_name}</span>
                    <div class="row">
                        <div class="col-md-2">
                            <label for="trx_order_price">Price:</label>
                        </div>
                        <div class="col-md-5">
                            <input type="number" class="form-control form-control-border form-control-sm" id="trx_order_price" value="${itemPrice}" readonly required>
                        </div>
                        <div class="col-md-3">
                            <input type="number" class="form-control form-control-border form-control-sm" id="trx_order_quantity" value="${quantity}" data-price="${itemPrice}" required>
                        </div>
                        <div class="col-md-2">
                            <label for="trx_order_quantity">orders</label>
                        </div>
                        <div class="col-md-2">
                            <label for="trx_total_amount">Total:</label>
                        </div>
                        <div class="col-md-5">
                            <input type="number" class="form-control form-control-border form-control-sm" id="trx_total_amount" value="${quantity * itemPrice}" readonly required>
                        </div>
                        <div class="col-md-5">
                            <input type="hidden" id="prd_id" value="" readonly>
                            <button class="btn btn-sm btn-danger mb-0 pb-0 mt-1" style="width: 100%" type="button" onclick="removeItem(this)"><i class="fa fa-trash" aria-hidden="true"></i></button>
                        </div>
                    </div>
                </div>
            </div>
        `;

                orderList.appendChild(newItem);

                // Add event listener to the new quantity input
                newItem.querySelector('#trx_order_quantity').addEventListener('input', updateTotalForItem);
            }

            updateTotals();
            toggleNoItemMessage();
        }

        function updateTotalForItem(event) {
            const quantityInput = event.target;
            const item = quantityInput.closest('li');
            const priceInput = item.querySelector('#trx_order_price');
            const totalInput = item.querySelector('#trx_total_amount');

            if (priceInput && totalInput) {
                totalInput.value = quantityInput.value * priceInput.value;
                updateTotals(); // Update the grand total
            } else {
                console.error('Price or Total input not found.');
            }
        }

        function updateTotals() {
            const totalQuantity = Array.from(document.querySelectorAll('#trx_order_quantity')).reduce((sum, input) => sum + parseInt(input.value) || 0, 0);
            const grandTotal = Array.from(document.querySelectorAll('#trx_total_amount')).reduce((sum, input) => sum + parseInt(input.value) || 0, 0);

            document.querySelector('#mtrx_total_orders').value = totalQuantity;
            document.querySelector('#mtrx_total').value = grandTotal;
        }

        function toggleNoItemMessage() {
            const orderList = document.querySelector('.item-content ul');
            const noItemMessage = document.querySelector('.item-content ul p');

            if (orderList.children.length > 0) {
                noItemMessage.style.display = 'none';
            } else {
                noItemMessage.style.display = 'block';
            }
        }

        function addItemToOrder(menu_name, mcat_name, itemPrice) {
            const quantityInput = event.target.closest('tr').querySelector('.item-quantity');
            const quantity = quantityInput.value;

            if (quantity > 0) {
                updateOrderList(menu_name, itemPrice, mcat_name, quantity);
                quantityInput.value = ''; // Clear the quantity input
            }
        }

        window.addItemToOrder = addItemToOrder; // Make the function globally accessible
    });

    function removeItem(button) {
        const item = button.closest('li');
        const quantityInput = item.querySelector('#trx_order_quantity');
        const priceInput = item.querySelector('#trx_order_price');
        const totalInput = item.querySelector('#trx_total_amount');

        if (quantityInput && priceInput && totalInput) {
            // Set values to 0 before removing the item
            quantityInput.value = 0;
            priceInput.value = 0;
            totalInput.value = 0;

            // Trigger the input event to update totals
            quantityInput.dispatchEvent(new Event('input'));
        }

        item.remove(); // Remove the item from the DOM
        updateTotals(); // Update the grand total
        toggleNoItemMessage(); // Update the visibility of the no-item message
    }
</script>

<script>
    // Select Categories
    document.getElementById('mcat_id').addEventListener('change', function () {
        let selectedCategory = this.value;
        let tableRows = document.querySelectorAll('tbody tr');

        tableRows.forEach(row => {
            let categoryCell = row.cells[1]; // The category is in the first cell
            let categoryValue = categoryCell.textContent.trim();

            if (selectedCategory === "" || categoryValue === selectedCategory) {
                row.style.display = ""; // Show row
            } else {
                row.style.display = "none"; // Hide row
            }
        });
    });
</script>
@endsection