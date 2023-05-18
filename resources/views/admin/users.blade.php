@extends('admin.layout.base')
@section('title', 'Users')
@section('data-page-id', 'adminUsers')

@section('content')
    <div class="users admin_shared">
        <div class="grid-padding-x">
            <div class="cell medium-11">
                <h2>Users</h2> <hr />
            </div>
        </div>

        @include('includes.message')

        <div class="grid-x grid-padding-x">
            <div class="small-12 medium-11 cell">
                @if(count($users))
                    <table class="hover unstriped">
                        <tbody>
                        <thead>
                        <tr>
                            <th>Username</th>
                            <th>Fullname</th>
                            <th>Email</th>
                            <th>Address</th>
                            <th>Role</th>
                            <th>Date Created</th>
                        </tr>
                        </thead>
                        @foreach($users as $user)
                            <tr>
                                <td>{{ $user['username'] }}</td>
                                <td>{{ $user['fullname'] }}</td>
                                <td>{{ $user['email'] }}</td>
                                <td>{{ $user['address'] }}</td>
                                <td style="display: flex; justify-content: space-between">
                                    {{ $user['role'] }}
                                    <span data-tooltip aria-haspopup="true"
                                          class="has-tip top" data-disable-hover="false"
                                          tabindex="1" title="Edit Product">
                                    <a data-open="item-{{ $user['id'] }}"><i class="fa fa-edit"></i></a>
                                    </span>


                                    <!-- Edit Role Modal -->
                                    <div class="reveal" id="item-{{ $user['id'] }}"
                                         data-reveal data-close-on-click="false" data-close-on-esc="false"
                                         data-animation-in="fade-in" data-animation-out="scale-out-up">
                                        <div class="notification callout primary">notif</div>
                                        <h2>Edit Role</h2>
                                        <form>
                                            <div class="input-group" style="display: block">
                                                <select id="item-{{ $user['id'] }}">
                                                    <option value="user" {{ $user['role'] === 'user' ? 'selected' : '' }}>User</option>
                                                    <option value="admin" {{ $user['role'] === 'admin' ? 'selected' : '' }}>Admin</option>
                                                </select>
                                                <div>
                                                    <input type="submit" class="button update-role"
                                                           id="update-role-{{ $user['id'] }}"
                                                           data-token="{{ \App\classes\CSRFToken::_token() }}"
                                                           value="Update">
                                                </div>
                                            </div>
                                        </form>
                                        <a href="/admin/users" class="close-button" data-close aria-label="Close modal" type="button">
                                            <span aria-hidden="true">&times;</span>
                                        </a>
                                    </div>
                                    <!-- End Edit Role Modal -->


                                </td>
                                <td>{{ $user['added'] }}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                    {!! $links !!}
                @else
                    <h2>You have not any registered user.</h2>
                @endif
            </div>
        </div>
    </div>
@endsection