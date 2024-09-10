@extends('admin.themes.layouts.main')

@section('title', 'Product Details')

@section('content')
{{-- Content Header) --}}
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Products Details</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a
                            href="{{ action('App\Http\Controllers\AdminController@home') }}">Home</a></li>
                    <li class="breadcrumb-item">Utility</li>
                    <li class="breadcrumb-item">Manage Product Details</li>
                </ol>
            </div>
        </div>
    </div>
</div>

{{-- Main Content --}}
<section class="content">
    <!-- Dashboard Content -->
    <div class="container-fluid">
        <div class="row mt-3">
            <div class="col-md-12">
                @if(session('usr_type') == '1')
                <a class="btn btn-primary float-right mb-3" href="javascript:void(0)" data-toggle="modal"
                    data-target="#newAnnouncementModal"><i class="fa fa-plus"></i> Add New Product</a>
                @endif
                <table class="table table-hover table-striped" id="RegTable">
                    <thead class="bg-gradient-dark">
                        <tr>
                            <th>SKU #</th>
                            <th>Product Name</th>
                            <th>Category</th>
                            <th>Category Value</th>
                            <th>Supplier</th>
                            <th class="text-center">Retail Price</th>
                            <th class="text-center">Dealer Price</th>
                            <th class="text-center">Purchase Price</th>
                            <th class="text-center">Quantity</th>
                            <th class="text-center">btn</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td class="text-right">₱ </td>
                            <td class="text-right">₱ </td>
                            <td class="text-right">₱ </td>
                            <td class="text-center"></td>
                            <td></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</section>

{{-- ? --}}
<div class="modal fade" id="newAnnouncementModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Create New Product</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="" method="POST">
                    @csrf
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="sup_id">Product Supplier:</label>
                                <select class="form-control" id="sup_id" name="sup_id" required>
                                    <option value="">--Select Product Supplier--</option>
                                </select>
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="prd_name">Product Name:</label>
                                <input type="text" class="form-control" id="prd_name" name="prd_name" required>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="cat_id">Category:</label>
                                <select class="form-control" id="cat_id" name="cat_id" required>
                                    <option value="">--Select Category--</option>
                                        <option value="">
                                        </option>
                                </select>
                            </div>
                        </div>
    
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="pcv_value">Attributes: <small><i>e.g. Color/etc (Optional)</i></small></label>
                                <input type="text" class="form-control" id="pcv_value" name="pcv_value">
                            </div>
                        </div>
    
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="prd_price_purchase">Purchase Price</label>
                                <input type="number" class="form-control" id="prd_price_purchase" name="prd_price_purchase" step="0.01" required>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="price_typ_retail">Retail Price:</label>
                                <input type="number" class="form-control" id="price_typ_retail" name="price_typ_retail" step="0.01" required>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="price_typ_dealer">Dealer Price</label>
                                <input type="number" class="form-control" id="price_typ_dealer" name="price_typ_dealer" step="0.01" required>
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="prd_stock_quantity">Current Stock Quantity:</label>
                                <input type="number" class="form-control" id="prd_stock_quantity" name="prd_stock_quantity" step="0.01" required>
                            </div>
                        </div>
                        
    
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="prd_sku_number">SKU Number</label>
                                <input type="text" class="form-control" id="prd_sku_number" name="prd_sku_number" required>
                            </div>
                        </div>
                    </div>
                
                    <!-- Subcategory Selection (conditionally shown) -->
                    {{-- <div class="form-group" id="subcategory-wrapper" style="display: none;">
                        <label for="sub_category_id">Subcategory:</label>
                        <select class="form-control" id="sub_category_id" name="sub_category_id">
                            <option value="">--Select Subcategory--</option>
                        </select>
                    </div> --}}
                
                    <!-- Submit Button -->
                    <button type="submit" class="btn btn-primary">Add Product</button>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection