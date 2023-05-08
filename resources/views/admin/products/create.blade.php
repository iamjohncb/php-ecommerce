@extends('admin.layout.base')
@section('title', 'Create Product')
@section('data-page-id', 'adminProducts')

@section('content')
    <div class="add-product">
        <div class="grid-x grid-padding-x">
            <div class="cell medium-11">
                <h2>Add Inventory Item</h2> <hr />
            </div>
        </div>
        @include('includes.message')

        <form method="POST" action="/admin/product/create">
            <div class="small-12 medium-11">
                <div class="grid-x grid-padding-x">
                    <div class="small-12 medium-6 cell">
                        <label>Product name:
                            <input type="text" name="name" placeholder="Product name"
                                   value="{{\App\classes\Request::old('post', 'name')}}">
                        </label>
                    </div>
                    <div class="small-12 medium-6 cell">
                        <label>Product price:
                            <input type="text" name="price" placeholder="Product price"
                                   value="{{\App\classes\Request::old('post', 'price')}}">
                        </label>
                    </div>
                    <div class="small-12 medium-6 cell">
                        <label>Product Category:
                            <select name="category" id="product-category">
                                <option value="{{\App\classes\Request::old('post', 'category')?:""}}">
                                    {{\App\classes\Request::old('post', 'category')?:"Select Category"}}
                                </option>
                                @foreach($categories as $category)
                                    <option value="{{$category->id}}">{{$category->name}}</option>
                                @endforeach
                            </select>
                        </label>
                    </div>
                    <div class="small-12 medium-6 cell">
                        <label>Product Subcategory:
                            <input type="text" name="price" placeholder="Product price"
                                   value="{{\App\classes\Request::old('post', 'price')}}">
                        </label>
                    </div>
                </div>
            </div>
        </form>

    </div>
    @include('includes.delete-modal')
@endsection