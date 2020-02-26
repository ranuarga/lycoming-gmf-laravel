@extends('layouts.track')

@section('title')
    Attachment
@endsection

@section('content')
<div class="container">
    <div class="table-responsive">
        <table clas="table table-bordered" width="100%" cellspacing="0">
            <tbody>
                @foreach($attachments as $attachment)
                <tr>
                    <td>
                        <a href="{{ $attachment->cloudinary_secure_url }}">Attachment {{ $loop->iteration }}</a>
                    </td>
                    <td>
                        <a href="" style="color:red">Delete</a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection