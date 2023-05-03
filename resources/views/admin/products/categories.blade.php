@extends('admin.layout.base')
@section('title','Product Categories')

@section('content')
    <div class="dashboard ">
        <div class="grid-x grid-padding-x">
            <div class="cell medium-11">
                <h2>Product Categories</h2>
            </div>
        </div>
        @if(isset($message))
            <p>{{$message}}</p>
        @endif
        <div class="grid-x grid-padding-x">
            <div class="small-12 medium-6 cell">
                <form action="" method="post">
                    <div class="input-group">
                        <input type="text" class="input-group-field" placeholder="Search by name">
                        <div class="input-group-button">
                            <input type="submit" class="button" value="Search">
                        </div>
                    </div>
                </form>
            </div>
            <div class="small-12 medium-5 end cell">
                <form action="/admin/product/categories" method="post">
                    <div class="input-group">
                        <input type="text" class="input-group-field" name="name" placeholder="Category name">
                        <input type="hidden" name="token" value="{{\App\classes\CSRFToken::_token()}}">
                        <div class="input-group-button">
                            <input type="submit" class="button" value="Create">
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <div class="grid-x grid-padding-x">
            <div class="small-12 medium-11 cell">
                @if(count($categories))
                    <table class="hover">
                        <tbody>
                        @foreach($categories as $category)
                            <tr>
                                <td>{{$category->name}}</td>
                                <td>{{$category->slug}}</td>
                                <td>{{$category->created_at->toFormattedDateString()}}</td>
                                <td width="100" class="text-right">
                                    <a href="#"><i class="fa fa-edit"></i></a>
                                    <a href="#"><i class="fa fa-times"></i></a>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                @else
                    <h3>You have not created any category</h3>
                @endif
            </div>
        </div>
    </div>
@endsection