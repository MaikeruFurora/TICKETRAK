 const form = document.getElementById("ticketForm");
    const dropzone = document.getElementById("dropzone");
    const fileInput = document.getElementById("fileInput");
    const fileCount = document.getElementById("fileCount");
    const fileList = document.getElementById("fileList");
    const clearBtn = document.getElementById("clearFiles");

    // Open file picker when clicking dropzone
    dropzone.addEventListener("click", () => fileInput.click());

    // Handle file selection
    fileInput.addEventListener("change", () => {
        const files = fileInput.files;
        fileList.innerHTML = "";

        if (files.length > 0) {
            fileCount.textContent = `${files.length} file(s) selected`;

            // Show first 3 files
            Array.from(files).slice(0, 3).forEach((file) => {
                const li = document.createElement("li");
                li.textContent = file.name;
                fileList.appendChild(li);
            });

            // If more than 4 files, show summary
            if (files.length > 4) {
                const li = document.createElement("li");
                li.textContent = `+${files.length - 3} attachment(s)`;
                fileList.appendChild(li);
            }

            clearBtn.classList.remove("d-none"); // show clear button
        } else {
            fileCount.textContent = "";
            clearBtn.classList.add("d-none"); // hide clear button
        }
    });

    // Clear files
    clearBtn.addEventListener("click", () => {
        fileInput.value = ""; // reset file input
        fileCount.textContent = "";
        fileList.innerHTML = "";
        clearBtn.classList.add("d-none"); // hide button again
    });

    form.addEventListener("submit", function () {
        submitBtn.disabled = true;
        submitText.textContent = "Submitting...";
        submitBtn.classList.add("disabled");
    });