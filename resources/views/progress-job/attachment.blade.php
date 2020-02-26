@extends('layouts.track')

@section('title')
    Attachment
@endsection

@section('content')
<div class="container">
    <div class="table-responsive">
        <table clas="table table-bordered" width="100%" cellspacing="0">
            <tbody>
            @if(count($attachments) != 0)
                @foreach($attachments as $attachment)
                <tr>
                    <td>
                        <a href="{{ $attachment->cloudinary_secure_url }}">Attachment {{ $loop->iteration }}</a>
                    </td>
                    <td>
                        <a href="{{ route('progress-attachment.deleteWeb', ['id' => $attachment->progress_job_id]) }}" style="color:red">
                            Delete
                        </a>
                    </td>
                </tr>
                @endforeach
            @else
            <tr>
                <td>
                    No Attachment
                </td>
            </tr>
            @endif
            </tbody>
        </table>
    </div>
</div>
@endsection