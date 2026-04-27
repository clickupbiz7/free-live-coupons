@extends('admin.layout')

@section('content')

<div class="container-fluid">

<div class="card border-0 shadow-sm rounded-4 overflow-hidden">

    <!-- TOP BAR -->
    <div class="p-4 border-bottom bg-white d-flex justify-content-between align-items-center flex-wrap gap-2">

        <div>
            <h3 class="fw-bold mb-1">Customer Message</h3>
            <small class="text-muted">
                View full customer inquiry
            </small>
        </div>

        <div class="d-flex gap-2">

            <button type="button"
		class="btn btn-success rounded-3 px-3"
		data-bs-toggle="modal"
		data-bs-target="#replyModal">

		<i class="fa fa-reply me-2"></i>Reply Now
	    </button>

            <a href="{{ route('admin.contact.messages') }}"
               class="btn btn-dark rounded-3 px-3">
                <i class="fa fa-arrow-left me-2"></i>Back
            </a>

        </div>

    </div>


    <!-- BODY -->
    <div class="p-4 bg-light-subtle">

        <!-- Sender Card -->
        <div class="bg-white rounded-4 shadow-sm p-4 mb-4">

            <div class="d-flex align-items-center gap-3">

                <div style="
                    width:65px;
                    height:65px;
                    border-radius:50%;
                    background:linear-gradient(135deg,#4f46e5,#ec4899);
                    color:#fff;
                    display:flex;
                    align-items:center;
                    justify-content:center;
                    font-size:26px;
                    font-weight:700;
                ">
                    {{ strtoupper(substr($message->name,0,1)) }}
                </div>

                <div>
                    <h5 class="fw-bold mb-1">{{ $message->name }}</h5>

                    <div class="text-muted">
                        {{ $message->email }}
                    </div>

                    <small class="text-muted">
                        {{ $message->created_at->format('d M Y h:i A') }}
                    </small>
                </div>

            </div>

        </div>


        <!-- Subject -->
        <div class="bg-white rounded-4 shadow-sm p-4 mb-4">

            <small class="text-uppercase text-muted fw-bold">
                Subject
            </small>

            <div class="mt-2">
                <span class="badge text-bg-primary px-3 py-2 rounded-pill fs-6">
                    {{ $message->subject }}
                </span>
            </div>

        </div>


        <!-- Message -->
        <div class="bg-white rounded-4 shadow-sm p-4">

            <small class="text-uppercase text-muted fw-bold">
                Message
            </small>

            <div class="mt-3 p-4 rounded-4"
                 style="
                 background:#f8fafc;
                 border:1px solid #e5e7eb;
                 line-height:1.9;
                 font-size:16px;
                 white-space:pre-line;
                 ">
                {{ $message->message }}
            </div>

        </div>

    </div>

</div>

<div class="modal fade" id="replyModal" tabindex="-1">
<div class="modal-dialog modal-lg">
<div class="modal-content border-0 rounded-4">

<form method="POST"
action="{{ route('admin.contact.messages.reply',$message->id) }}">

@csrf

<div class="modal-header">
<h5 class="modal-title fw-bold">
Reply to {{ $message->name }}
</h5>

<button type="button"
class="btn-close"
data-bs-dismiss="modal"></button>
</div>

<div class="modal-body">

<div class="mb-3">
<label class="form-label fw-semibold">
To
</label>

<input type="text"
class="form-control"
value="{{ $message->email }}"
readonly>
</div>

<div class="mb-3">
<label class="form-label fw-semibold">
Subject
</label>

<input type="text"
name="subject"
class="form-control"
value="Re: {{ $message->subject }}"
required>
</div>

<div class="mb-3">
<label class="form-label fw-semibold">
Message
</label>

<textarea name="message"
rows="8"
class="form-control"
required>Hello {{ $message->name }},

Thank you for contacting us. 
We appreciate your interest and will respond to your inquiry as soon as possible.
</textarea>
</div>

</div>

<div class="modal-footer">

<button type="button"
class="btn btn-light border"
data-bs-dismiss="modal">
Cancel
</button>

<button class="btn btn-success px-4">
Send Reply
</button>

</div>

</form>

</div>
</div>
</div>

</div>

@endsection