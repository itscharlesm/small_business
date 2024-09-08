@extends('admin.themes.layouts.main')

@section('title', 'Manage Clients')

@section('content')
{{-- Content Header) --}}
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Manage Clients</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a
                            href="{{ action('App\Http\Controllers\AdminController@home') }}">Home</a></li>
                    <li class="breadcrumb-item">Utility</li>
                    <li class="breadcrumb-item">Manage Clients</li>
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
                    data-target="#newAnnouncementModal"><i class="fa fa-plus"></i> Add New Client</a>
                @endif
                <table class="table table-hover table-striped" id="RegTable">
                    <thead class="bg-gradient-dark">
                        <tr>
                            <th>#</th>
                            <th>Name</th>
                            <th>Address</th>
                            <th>Contact Number</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($clients as $client)
                        <tr>
                            <td>{{ $client->clt_id }}</td>
                            <td>{{ $client->clt_name }}</td>
                            <td>{{ $client->clt_address ?? 'N/A' }}</td>
                            <td>{{ $client->clt_contact ?? 'N/A' }}</td>
                            <td></td>
                        </tr>
                        @endforeach
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
                <h5 class="modal-title" id="exampleModalLabel">Add New Client</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{ action('App\Http\Controllers\UtilityController@add_clients_manage') }}" method="POST">
                    @csrf
                    <!-- Product Name -->
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="clt_name">Client Name:</label>
                                <input type="text" class="form-control" id="clt_name" name="clt_name" required>
                            </div>
                        </div>
    
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="clt_address">clt_address:</label>
                                <input type="text" class="form-control" id="clt_address" name="clt_address" required>
                            </div>
                        </div>
    
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="clt_contact">Contact Number:</label>
                                <input type="text" class="form-control" id="clt_contact" name="clt_contact" step="0.01" required>
                            </div>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-primary">Add</button>
                </form>
            </div>
        </div>
    </div>
</div>

{{-- <script>
    document.getElementById('category_id').addEventListener('change', function() {
        const categoryId = this.value;
        const hasSubcategories = this.options[this.selectedIndex].getAttribute('data-has-subcategories') === 'true';

        if (hasSubcategories) {
            // Show subcategory dropdown
            document.getElementById('subcategory-wrapper').style.display = 'block';

            // Fetch subcategories (you may use AJAX to dynamically load based on category)
            fetch(`/categories/${categoryId}/subcategories`)
                .then(response => response.json())
                .then(subcategories => {
                    const subCategorySelect = document.getElementById('sub_category_id');
                    subCategorySelect.innerHTML = '<option value="">--Select Subcategory--</option>';
                    subcategories.forEach(subcategory => {
                        const option = document.createElement('option');
                        option.value = subcategory.sub_category_id;
                        option.text = subcategory.name;
                        subCategorySelect.appendChild(option);
                    });
                });
        } else {
            // Hide subcategory dropdown
            document.getElementById('subcategory-wrapper').style.display = 'none';
        }
    });
</script> --}}

@endsection