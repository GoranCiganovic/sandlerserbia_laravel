@extends('layouts.app')

@section('title', 'Unauthorized Action')

@section('content')
<div class="container main-container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading san-yell">
                    <h4>401 Unauthorized Action</h4>
                </div>
                <div class="panel-body san-yell">
                    <div class="row">
                        <div class="col-sm-8 col-sm-offset-2 col-md-8 col-md-offset-2 col-lg-7 col-lg-offset-3">
                            <h3>{{ $exception->getMessage() }}</h3>
                        </div>
                        <img class="img-responsive col-sm-2" src="{{ asset('/storage/images/sandler/eagle.png') }}" alt="Sandler Eagle">
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
