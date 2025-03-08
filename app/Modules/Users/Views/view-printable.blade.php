<?php


use App\Libraries\CommonFunction;
use App\Libraries\Encryption;
use Illuminate\Support\Facades\Auth;

 ?>


@extends('layouts.admin')

@section('header-resources')
@endsection

@section('content')

    {!! Form::open(array('url' => 'users/reject/'.Request::segment(3),'method' => 'post', 'class' => 'form-horizontal', 'id' => 'rejectUser')) !!}
    <!-- Modal -->
    <div class="modal fade" id="myModal2" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel">Reject User</h4>
                </div>
                
                <div class="modal-footer">
                    
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save</button>
                 
                </div>
            </div>
        </div>
    </div>
    <!-- End Modal -->

    {!! Form::close() !!}

    <div class="row"> <!-- Horizontal Form -->
        <div class="col-sm-12">
            {!! Form::open(array('url' => '/users/approve/'.Encryption::encodeId($user->id),'method' => 'post', 'class' => 'form-horizontal',   'id'=> 'user_edit_form')) !!}
            <div class="panel panel-primary">
                <div class="panel-heading">
                    <h5><strong>Profile of : {!!$user->name !!}</strong></h5>
                </div> <!-- /.panel-heading -->

                <div class="panel-body">
                    <div class="col-md-3 text-center">
                        <br/>
                        @if (!empty($user->user_pic))
                            <img src="{{ url('/users/upload/' . $user->user_pic) }}" alt="Profile picture"
                                 class="profile-user-img img-responsive img-circle" witdh="200"/>
                        @else
                            <img src="{{ url('/assets/images/default_profile.jpg') }}" alt="Profile picture"
                                 class="profile-user-img img-responsive img-circle" witdh="200"/>
                        @endif

                        <br/>
                        
                    </div>
                    <div class="col-md-9">

                    <div class="col-md-9">
                        <div class="profile-info" style="overflow-wrap: break-word">
                            <div class="row">
                                <strong class="col-md-4">Full Name</strong>
                                <span class="col-md-8">: {!! $user->name  !!}</span>
                            </div>
                            <div class="row">
                                <strong class="col-md-4">Type</strong>
                                <span class="col-md-8">: {!! $user->type_name !!}</span>
                            </div>
                            
                            <div class="row">
                                <strong class="col-md-4">Phone</strong>
                                <span class="col-md-8">: {!! $user->phone !!}</span>
                            </div>
                            <div class="row">
                                <strong class="col-md-4">Email</strong>
                                <span class="col-md-8">: {!! $user->email !!}</span>
                            </div>
                            <div class="row">
                                <strong class="col-md-4">Status</strong>
                                <span class="col-md-8">: {!! $user->user_status !!}</span>
                            </div>
                           
                        </div>

                    

                        </div>

                       
                    </div>
                </div><!-- /.box -->

                <div class="panel-footer">
                    <div class="pull-left">
                        <a href="{{ URL::previous() }}" class="btn btn-sm btn-default"><i
                                    class="fa fa-times"></i> Close</a>
                    </div>
                    <div class="pull-right">
                        <?php
                        
                        $edit = '<a href="' . url('users/edit/' . Encryption::encodeId($user->id)) . '" class="btn btn-sm btn-primary"><i class="fa fa-edit"></i> Edit</a>';
                        $reset_password = '<a href="' . url('users/reset-password/' . Encryption::encodeId($user->id)) . '" class="btn btn-sm btn-warning"'
                            . 'onclick="return confirm(\'Are you sure?\')">'
                            . '<i class="fa fa-refresh"></i> Reset password</a>';

                        $logged_in_user_type = Auth::user()->user_type;
                        $activate = '';
                        if ($logged_in_user_type == '1x101' || CommonFunction::isTeamLeader()) {
                            if ($user->user_status == 'inactive') {
                                $activate = '<a href="' . url('users/activate/' . Encryption::encodeId($user->id)) . '" class="btn btn-sm btn-success"><i class="fa fa-unlock"></i>  Activate</a>';
                            } else {
                                $activate = '<a href="' . url('users/activate/' . Encryption::encodeId($user->id)) . '" class="btn btn-sm btn-danger"'
                                    . 'onclick="return confirm(\'Are you sure?\')">'
                                    . '<i class="fa fa-unlock-alt"></i> Deactivate</a>';
                            }
                        }
                        echo '&nbsp;' . $activate;
                        echo '&nbsp;' . $edit;
                        ?>
                    </div>
                    <div class="clearfix"></div>
                </div>
            </div>

            {!! Form::close() !!}
        </div>
    </div>

@endsection <!--content section-->