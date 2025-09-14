$(function(){
    document.getElementById("replyForm").addEventListener("submit", function (e) {
    const btn = document.getElementById("submitBtn");
    btn.disabled = true; // prevent double click
    btn.innerText = "Submitting...";
    });

    const dropzone = document.getElementById("dropzone");
    const fileInput = document.getElementById("fileInput");
    const fileCount = document.getElementById("fileCount");
    const fileList = document.getElementById("fileList");
    const clearBtn = document.getElementById("clearFiles");
    let ticket_id = $("#user-select").data("ticket-id");
    let assigned_by_id = $("#user-select").data("assigned-by-id");

    dropzone.addEventListener("click", () => fileInput.click());

    fileInput.addEventListener("change", () => {
        const files = fileInput.files;
        fileList.innerHTML = "";

        if (files.length > 0) {
            fileCount.textContent = `${files.length} file(s) selected`;

            Array.from(files).forEach((file) => {
                const li = document.createElement("li");
                li.textContent = file.name;
                fileList.appendChild(li);
            });

            clearBtn.classList.remove("d-none"); // show clear button
        } else {
            fileCount.textContent = "";
            clearBtn.classList.add("d-none"); // hide clear button
        }
    });

    // Clear files when X button clicked
    clearBtn.addEventListener("click", () => {
        fileInput.value = ""; // reset input
        fileList.innerHTML = ""; // clear file list
        fileCount.textContent = ""; // clear count
        clearBtn.classList.add("d-none"); // hide button
    });

    $("#user-select").select2({
        placeholder: "Search for a user to assign...",
        allowClear: true,
        ajax: {
            url: "/api/account/user/search",
            dataType: "json",
            delay: 250,
            data: function (params) {
                return {
                    q: params.term, // search term
                    page: params.page || 1,
                };
            },
            processResults: function (data) {
                return {
                    results: data.results,
                    pagination: {
                        more: data.pagination.more,
                    },
                };
            },
        },
    });

        let userIdx = $("#user-select").data("assigned-to-id");
        let userNamex = $("#user-select").data("assigned-to-name");

        if (userIdx && userNamex) {
            // clear existing value
            $("#user-select").val(null).trigger("change");

            // create new option (selected = true)
            let newOption = new Option(userNamex, userIdx, true, true);

            // append & select
            $("#user-select").append(newOption).trigger("change");
        }


    // Save to database when a user is selected
    $("#user-select").on("select2:select", function (e) {
        let assigned_to_id = e.params.data.id;
        let name = e.params.data.text || e.params.data.name;

        // confirm before saving
        alertify
            .confirm(
                "Assign Ticket",
                "Are you sure you want to assign " + name + "?",
                function () {
                    $(".user-select-text").prop("disabled", true).text("Saving...");
                    // yes → save user
                    $.ajax({
                        url: "/api/account/assign/ticket",
                        method: "post",
                        data: {
                            assigned_to: assigned_to_id,
                            assigned_by: assigned_by_id,
                            ticket_id: ticket_id,
                            _token: $('meta[name="csrf-token"]').attr("content"),
                        },
                        success: function (response) {
                            if (response.success) {
                                alertify.success(response.message);

                                if (response.assigned_user) {
                                    let userId = response.assigned_user.id;
                                    let userName = response.assigned_user.name;

                                    // check if option already exists
                                    if (
                                        $('#user-select option[value="' +userId +'"]').length === 0
                                    ) {
                                        // append option if it doesn't exist
                                        let newOption = new Option(
                                            userName,
                                            userId,
                                            true,
                                            true
                                        );
                                        $("#user-select")
                                            .append(newOption)
                                            .trigger("change");
                                    } else {
                                        // just select the existing option
                                        $("#user-select")
                                            .val(userId)
                                            .trigger("change");
                                    }
                                }
                            } else {
                                alertify.warning("Failed to update status");
                            }
                        },
                        complete: function () {
                            $(".user-select-text").prop("disabled", false).text("");
                        },
                        error: function (xhr) {
                            console.error(xhr.responseText);
                            alertify.error("Error saving user.");
                        },
                    });
                },
                function () {
                    $("#user-select")
                        .prop("disabled", false)
                        .val(null)
                        .trigger("change");
                    alertify.warning("Assignment cancelled");
                }
            )
            .set("labels", { ok: "Assign", cancel: "No" }); // customize button labels
    });

    $("#priority-status").on("change", function () {
        let ticketId = $(this).data("ticket-id");
        let priority = $(this).val();

        $(".priority-status-text").text("Saving...");
        $.ajax({
            url: `/api/tickets/assign/priority-status`,
            type: "POST",
            data: {
                ticket_id: ticketId,
                priority: priority,
                _token: $('meta[name="csrf-token"]').attr("content"),
            },
            success: function (response) {
                console.log(response.success, response.message);

                if (response.success) {
                    alertify.success(response.message);
                } else {
                    alertify.warning("Failed to update status");
                }
            },
            complete: function () {
              $(".priority-status-text").text("");  
            },
            error: function () {
                alertify.warning("Something went wrong. Try again.");
            },
        });
    });

    document.getElementById("status-form").addEventListener("submit", function (e) {
        e.preventDefault(); // stop auto-submit
        let status = this.getAttribute("data-status");
        alertify
            .confirm(
                "Change Ticket Status",
                `Are you sure you want to ${
                    status == "Open" ? "close" : "reopen"
                } this ticket?`,
                () => {
                    this.submit();
                }, // confirm → submit form
                () => {
                    alertify.warning("Cancelled");
                } // cancel → do nothing
            )
            .set({ labels: { ok: "Yes", cancel: "No" }, closableByDimmer: false });
    });


})
document.addEventListener("DOMContentLoaded", function () {
    const collapseEl = document.getElementById("ticketOptions");
    collapseEl.addEventListener("show.bs.collapse", function () {
        collapseEl.previousElementSibling
            .querySelector(".collapse-show")
            .classList.add("d-none");
        collapseEl.previousElementSibling
            .querySelector(".collapse-hide")
            .classList.remove("d-none");
    });
    collapseEl.addEventListener("hide.bs.collapse", function () {
        collapseEl.previousElementSibling
            .querySelector(".collapse-show")
            .classList.remove("d-none");
        collapseEl.previousElementSibling
            .querySelector(".collapse-hide")
            .classList.add("d-none");
    });
});