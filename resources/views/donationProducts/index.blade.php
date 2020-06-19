<div class="container">
    <div class="section">
        <div id="breadcrumbs-wrapper">
            <div class="container">
                <div class="row">
                    <div class="col s10 m6 l6">
                        <h5 class="breadcrumbs-title">Related Products</h5>
                        <ol class="breadcrumbs">
                            <li><a href="{{route('home')}}">Dashboard</a>
                            </li>
                            <li><a href="{{route('donation-categories.index')}}">Donation Categories</a>
                            </li>
                            <li class="active">Related Products</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>

        <div id="table-datatables">
            <div class="row">
                <div class="col s12">
                    <a class="btn waves-effect waves-light primary-btn-bgcolor"
                       href={{ route('donationProductCreate', $category->id) }}>Create</a>
                </div>
                <div class="col s12">
                    <table id="data-table-simple" class="responsive-table display" cellspacing="0">
                        <thead>
                        <tr>
                            <th>Id</th>
                            <th>Category</th>
                            <th>name</th>
                            <th>Redeem Points</th>
                            <th>Description</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($category->donationProducts as $product)
                            <tr>
                                <td>{{ $product->id }}</td>
                                <td>{{ $product->category->name }}</td>
                                <td>{{ $product->name }}</td>
                                <td>{{ $product->redeem_points }}</td>
                                <td>{{ $product->description }}</td>
                                <td>{{ $product->status == 0 ? 'Inactive' : 'Active'}}</td>
                                <td>
                                    <a href="{{ route('donation-products.edit', $product->id) }}" class="btn waves-effect waves-light blue accent-2"><i class="fa fa-edit"></i></a>
                                    {{ Form::open(['url' => route('donation-products.destroy', $product->id), 'method' => 'DELETE', 'class' => 'form-inline']) }}
                                    <button type="submit" class="btn btn-danger red delete"><i class="fa fa-trash "></i></button>
                                    {{ Form::close() }}
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
