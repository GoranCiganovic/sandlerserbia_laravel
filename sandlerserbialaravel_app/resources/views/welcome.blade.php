@extends('layouts.app')

@section('title', 'Sandler Serbia Welcome')
    
@section('content')
<div class="container main-container"> 
    <div class="col-md-10 col-md-offset-1">
        <div class="panel panel-default">
            <div class="panel-heading san-yell">
                <h4>Welcome</h4>
            </div>
            <div class="panel-body san-yell">

                <div class="row">


                    <div class="col-sm-2 col-xs-5 h1">
                       <img class="img-responsive" src="{{ asset('/storage/images/sandler/eagle.png') }}" alt="Sandler Eagle">
                    </div>

                    <div class="col-sm-7 col-sm-offset-1 col-xs-7 text-center">
                        <h1>Sandler Serbia</h1>
                    </div>

                </div>
               
            </div>
        </div>
    </div>
</div>
@endsection

