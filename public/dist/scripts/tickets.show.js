document.getElementById('replyForm').addEventListener('submit', function(e) {
        const btn = document.getElementById('submitBtn');
        btn.disabled = true; // prevent double click
        btn.innerText = 'Submitting...';
    });

    const dropzone  = document.getElementById('dropzone');
    const fileInput = document.getElementById('fileInput');
    const fileCount = document.getElementById('fileCount');
    const fileList  = document.getElementById('fileList');
    const clearBtn  = document.getElementById('clearFiles');
    let   ticket_id     = $('#user-select').data('ticket-id');
    let   assigned_by_id= $('#user-select').data('assigned-by-id');

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

            clearBtn.classList.remove('d-none'); // show clear button
        } else {
            fileCount.textContent = '';
            clearBtn.classList.add('d-none'); // hide clear button
        }
    });

    // Clear files when X button clicked
    clearBtn.addEventListener('click', () => {
        fileInput.value = '';         // reset input
        fileList.innerHTML = '';      // clear file list
        fileCount.textContent = '';   // clear count
        clearBtn.classList.add('d-none'); // hide button
    });



    $('#user-select').select2({
        placeholder: 'Search for a user to assign...',
        allowClear: true,
        ajax: {
            url: '/api/account/user/search',
            dataType: 'json',
            delay: 250,
            data: function (params) {
                return {
                    q: params.term, // search term
                    page: params.page || 1
                };
            },
            processResults: function (data) {
                return {
                    results: data.results,
                    pagination: {
                        more: data.pagination.more
                    }
                };
            }
        }
    });

    // Save to database when a user is selected
   $('#user-select').on('select2:select', function (e) {
        let assigned_to_id = e.params.data.id;

        // confirm before saving
        alertify.confirm(
            "Assign User",
            "Are you sure you want to assign this user?",
            function () {
                // yes → save user
                $.ajax({
                    url: '/api/account/assign/ticket',
                    method: 'post',
                    data: {
                        assigned_to: assigned_to_id,
                        assigned_by: assigned_by_id,
                        ticket_id: ticket_id,
                        _token: $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function (res) {
                        alertify.success('User assigned successfully!');
                        setTimeout(() => {
                            window.location.reload();
                        }, 1200);
                    },
                    error: function (xhr) {
                        console.error(xhr.responseText);
                        alertify.error('Error saving user.');
                    }
                });
            },
            function () {
                alertify.warning('Assignment cancelled');
            }
        ).set('labels', {ok:'Yes', cancel:'No'}); // customize button labels
    });