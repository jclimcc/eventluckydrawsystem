@extends('voyager::master')

@section('page_title', __('voyager::generic.'.(isset($dataTypeContent->id) ? 'edit' : 'add')).' '.$dataType->display_name_singular)

@section('content')
    <div class="page-content edit-add container-fluid">
        <div class="row">
            <div class="col-md-12">

                <div class="panel panel-bordered">
                    <!-- form start -->
                    <form role="form"
                          class="form-edit-add"
                          action="@if(isset($dataTypeContent->id)){{ route('voyager.'.$dataType->slug.'.update', $dataTypeContent->id) }}@else{{ route('voyager.'.$dataType->slug.'.store') }}@endif"
                          method="POST" enctype="multipart/form-data">
                        <!-- PUT Method if we are editing -->
                        @if(isset($dataTypeContent->id))
                            {{ method_field("PUT") }}
                        @endif

                        <!-- CSRF TOKEN -->
                        {{ csrf_field() }}

                        <div class="panel-body">

                            <!-- Adding / Editing -->
                            @php
                                $dataTypeRows = $dataType->{(isset($dataTypeContent->id) ? 'editRows' : 'addRows' )};
                            @endphp

                            @foreach($dataTypeRows as $row)
                                <!-- GET THE DISPLAY OPTIONS -->
                                @php
                                    $options = json_decode(json_encode($row->details));
                                    $display_options = isset($options->display) ? $options->display : NULL;
                                @endphp
                                @if ($options && isset($options->formfields_custom))
                                    @include('voyager::formfields.custom.' . $options->formfields_custom)
                                @else
                                    <div class="form-group @if($row->type == 'hidden') hidden @endif col-md-{{ $display_options->width ?? 12 }} @if(isset($display_options->offset)) col-md-offset-{{ $display_options->offset }} @endif" @if(isset($display_options->id)){{ "id=$display_options->id" }}@endif>
                                        {{ $row->slugify }}
                                        <label for="name">{{ $row->display_name }}</label>
                                        @include('voyager::multilingual.input-hidden-bread-edit-add')
                                        @if($row->type == 'relationship')
                                            {{-- @include('voyager::formfields.relationship', ['options' => $options]) --}}
                                            
                                        
                                            @if($row->display_name == 'prizes') <!-- replace 'prizes' with the actual field name in your events table -->
                                            @if(isset($dataTypeContent->prizes))
                                            <ul>
                                                @foreach($dataTypeContent->prizes as $prize)
                                                    <li>{{ $prize->name }} [{{ $prize->total_number }}]</li>
                                                @endforeach
                                            </ul>
                                            @else
                                                    <label>No result</label>
                                            @endif
                                        @endif

                                        @else
                                            {!! app('voyager')->formField($row, $dataType, $dataTypeContent) !!}
                                        @endif

                                        @foreach (app('voyager')->afterFormFields($row, $dataType, $dataTypeContent) as $after)
                                            {!! $after->handle($row, $dataType, $dataTypeContent) !!}
                                        
                                        @endforeach

                                        
                                    </div>
                                @endif
                            @endforeach

                        </div><!-- panel-body -->

                        <div class="panel-footer">
                            @section('submit-buttons')
                                <button type="submit" class="btn btn-primary save">{{ __('voyager::generic.save') }}</button>
                            @stop
                            @yield('submit-buttons')
                        </div>
                    </form>

                    <iframe id="form_target" name="form_target" style="display:none"></iframe>
                    <form id="my_form" action="{{ route('voyager.upload') }}" target="form_target" method="post"
                          enctype="multipart/form-data" style="width:0;height:0;overflow:hidden">
                        <input name="image" id="upload_file" type="file"
                               onchange="$('#my_form').submit();this.value='';">
                        <input type="hidden" name="type_slug" id="type_slug" value="{{ $dataType->slug }}">
                        {{ csrf_field() }}
                    </form>

                </div>
            </div>
        </div>
    </div>
@stop

@section('javascript')
    <script>
        $('document').ready(function () {
            $('.toggleswitch').bootstrapToggle();
        });
    </script>
@stop