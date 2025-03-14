@extends('admin.layouts.master')

@section('header')
    <div class="row page-titles">
        <div class="col-md-5 col-12 align-self-center">
            <h2 class="mb-0">
                <small>Edit</small>
            </h2>
        </div>
        <div class="col-md-7 col-12 align-self-center d-none d-md-flex justify-content-end">
            <ol class="breadcrumb mb-0 p-0 bg-transparent">
                <li class="breadcrumb-item"><a href="{{ admin_url() }}">{{ trans('admin.dashboard') }}</a></li>
                <li class="breadcrumb-item active d-flex align-items-center">{{ trans('admin.add') }}</li>
            </ol>
        </div>
    </div>
@endsection

@section('content')
    <div class="flex-row d-flex justify-content-center">
        <div class="col-sm-12">
            
           
            
           
            <div class="card border-top border-primary">
                
                <div class="card-header">
                    <h3 class="mb-0">Modify slider details</h3>
                </div>
                <div class="card-body">
                     <form role="form" action="{!! route('sliders.edit') !!}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <input type="text" name="idS" value="{{$slider->id}}" hidden>
                        {{-- Show the erros, if any --}}
                        @if ($errors->any())
                            <div class="alert alert-danger alert-dismissible bg-danger text-white border-0 fade show" role="alert">
                                <h4 class="alert-heading">{{ trans('admin.please_fix') }}</h4>
                                <ul>
                                    @foreach($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        {{-- Show the inputs --}}
                        <div class="card mb-0">
                            <div class="row">
                                <div class="mb-3 col-md-12">
                                    <label class="form-label fw-bolder">Expiry Time</label>
                                    
                                    <input
                                        type="date"
                                        name="extime"
                                        value="{{$slider->exf_time}}"
                                        class="form-control"
                                        required
                                        >

                                </div>

                                <div class="mb-3 col-md-12">
                                    <label class="form-label fw-bolder">Slider Upload</label>
                                    

                                    {{-- Show the file picker on CREATE form. --}}
                                    <input
                                        type="file"
                                        id="slider_file_input"
                                        name="file"
                                        value=""
                                        class="form-control"
                                    > 
                                </div>
                            </div>
                        </div>


                        <div id="saveActions">
	
                           
                            <div class="btn-group">
                                
                                <button type="submit" class="btn btn-primary shadow">
                                    <span class="fa fa-save" role="presentation" aria-hidden="true"></span> &nbsp;
                                    <span data-value="">Save</span>
                                </button>
                            </div>
                        </div>
                    </form> 
                </div>
                
            </div>
        </div>
    </div>

@endsection


