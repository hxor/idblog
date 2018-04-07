@extends('layouts.admin.app')

@section('content')
    <div class="container-fluid">
        <!-- Breadcrumbs-->
        <ol class="breadcrumb">
          <li class="breadcrumb-item">
            <a href="#">Comments</a>
          </li>
          <li class="breadcrumb-item active">Comment Detail</li>
        </ol>
        <!-- Icon Cards-->
        <div class="row">
          <div class="col-md-12">
            <div class="card">
              <div class="card-header text-white bg-primary">
                Comment Detail : {{ $comment->post->title }}
              </div>
              <div class="card-body">
                  <table class="table table-striped">
                      <tr>
                          <th>ID</th>
                          <td>{{ $comment->id }}</td>
                      </tr>
                      <tr>
                          <th>Author</th>
                          <td>{{ $comment->name }}</td>
                      </tr>
                      <tr>
                          <th>Email</th>
                          <td>{{ $comment->email }}</td>
                      </tr>
                      <tr>
                          <th>Comment</th>
                          <td>{{ $comment->body }}</td>
                      </tr>
                      <tr>
                          <th>Created At</th>
                          <td>{{ $comment->created_at }}</td>
                      </tr>
                      <tr>
                          <th>Status</th>
                          <td>{{ $comment->status == 0 ? 'Draft' : 'Published' }}</td>
                      </tr>
                  </table>
              </div>
            </div>
          </div>
        </div>
    </div>
@endsection