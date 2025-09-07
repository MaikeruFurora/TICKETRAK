@extends('layout.app')
@section('content')
<div class="page-header">
    <div class="row align-items-center">
        <div class="col">
            <h2 class="page-title">Submit a Support Ticket</h2>
            <div class="text-muted my-2">Need help? We're here to assist! Please provide as much detail as possible so we can resolve your issue quickly and efficiently.</div>
        </div>
        <div class="col-auto ms-auto">
        <div class="btn-list">
            <span class=" d-sm-inline">
            <a href="{{  route('auth.tickets.index') }}" class="btn"> 
              <svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-arrow-left"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M5 12l14 0" /><path d="M5 12l6 6" /><path d="M5 12l6 -6" /></svg>
            Back </a>
            </span>
        </div>
        </div>
    </div>
</div>  
<div class="row">
    <div class="col-sx-12 col-xl-8">
         @if (session('message'))
            <div class="alert alert-danger">
                {{ session('message') }}
            </div>
        @endif
         <div class="card card-md mt-3">
    <div class="card-body">
         {{-- <p class="text-muted">
            Fill out the form below to submit a new support ticket. Please provide as many details as possible so we can resolve your issue quickly.
        </p> --}}
        <form action="{{ route('auth.tickets.store') }}" method="POST" autocomplete="off" enctype="multipart/form-data">
            @csrf
            <input type="text" hidden value="{{ Auth::user()->id }}" name="user_id">
            <div class="mb-3">
                <label class="form-label">Subject</label>    
                <input type="text" class="form-control" maxlength="120" placeholder="What's the main issue" name="subject">
            </div>
            <div class="mb-3">
                <label class="form-label">Describe your issue in detail</label>    
                <textarea class="form-control" rows="5" maxlength="1000" placeholder="Please describe your issue in detail." name="description"></textarea>
            </div>
            <div class="mb-4">
                <label for="fileInput" class="form-label">
                Attachment Screenshot or relevant file (optional)
                </label>

                <div id="dropzone" class="dropzone dz-clickable text-center p-4 border border-dashed rounded bg-light">
                <div class="dz-message">
                    <svg xmlns="http://www.w3.org/2000/svg" width="36" height="36" viewBox="0 0 24 24" fill="none"
                        stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                        class="icon icon-tabler icon-tabler-cloud-upload mb-2 text-primary">
                    <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                    <path d="M12 18.004h-5.343c-2.572 -.004 -4.657 -2.011 -4.657 -4.487c0 -2.475 2.085 -4.482 4.657 -4.482
                            c.393 -1.762 1.794 -3.2 3.675 -3.773c1.88 -.572 3.956 -.193 5.444 1c1.488 1.19 2.162 3.007 1.77 4.769h.99
                            c1.38 0 2.57 .811 3.128 1.986" />
                    <path d="M19 22v-6" />
                    <path d="M22 19l-3 -3l-3 3" />
                    </svg>
                    <p class="text-muted mb-0">
                    Drag and drop files here or <span class="text-primary fw-bold">click to browse</span>
                    </p>
                        <!-- File count -->
                            <p id="fileCount" class="mt-2 text-secondary small"></p>
                            <!-- Centered File names list -->
                            <ul id="fileList" class="list-unstyled small text-center mt-2"></ul>

                </div>
                </div>
                <input type="file" class="d-none" id="fileInput" multiple name="attachments[]">
            </div>
            <div class="mb-1">
                <button type="submit" class="btn btn-primary"><svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="1"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-send"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M10 14l11 -11" /><path d="M21 3l-6.5 18a.55 .55 0 0 1 -1 0l-3.5 -7l-7 -3.5a.55 .55 0 0 1 0 -1l18 -6.5" /></svg>Submit</button>
            </div>
        </form> 
    </div>
</div>
</div>
    <div class="col-sx-12 col-xl-4 mt-3">
        <div class="card">
            <div class="card-body">
                <p>What happens next?</p>
                <p class="text-muted">Once you submit a support ticket, our support team will get in touch with you to resolve your issue.</p>
            </div>
        </div>
    </div>
</div>
@endsection
@section('scripts')
<script>
  const dropzone = document.getElementById('dropzone');
  const fileInput = document.getElementById('fileInput');
  const fileCount = document.getElementById('fileCount');
  const fileList = document.getElementById('fileList');

  dropzone.addEventListener('click', () => fileInput.click());

  fileInput.addEventListener('change', () => {
    const files = fileInput.files;
    fileList.innerHTML = '';

    if (files.length > 0) {
      fileCount.textContent = `${files.length} file(s) selected`;

      Array.from(files).forEach(file => {
        const li = document.createElement('li');
        li.textContent = file.name;
        fileList.appendChild(li);
      });
    } else {
      fileCount.textContent = '';
    }
  });
</script>
@endsection