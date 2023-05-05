<div class="grid-padding-x cell">
    @if(isset($errors))
        <div class="callout alert" data-closable>
            @foreach($errors as $error_array)
                @foreach($error_array as $error_item)
                        {{$error_item}} <br/>
                @endforeach
            @endforeach
                <button class="close-button" aria-label="Dismiss Message" type="button" data-close>
                        <span aria-hidden="true">&times;</span>

                </button>
        </div>
    @endif
            @if(isset($succes) || \App\classes\Session::has('success'))
                    <div class="callout success" data-closable>
                            @if(isset($succes))
                                {{$succes}}
                        @elseif(\App\classes\Session::has('success'))
                        {{\App\classes\Session::flash('success')}}
                        @endif
                            <button class="close-button" aria-label="Dismiss Message" type="button" data-close>
                                    <span aria-hidden="true">&times;</span>

                            </button>
                    </div>
            @endif
</div>