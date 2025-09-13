const form = document.getElementById("ticketForm");
const dropzone = document.getElementById("dropzone");
const fileInput = document.getElementById("fileInput");
const fileCount = document.getElementById("fileCount");
const fileList = document.getElementById("fileList");
const clearBtn = document.getElementById("clearFiles");

const submitBtn = document.getElementById("submitBtn");   // <-- make sure you add this id in HTML
const submitText = document.getElementById("submitText"); // <-- wrap button text in a span with this id

let files = []; // store selected files

// Open file picker when clicking dropzone
dropzone.addEventListener("click", () => fileInput.click());

// Handle drag & drop
dropzone.addEventListener("dragover", (e) => {
  e.preventDefault();
  dropzone.classList.add("dragover");
});
dropzone.addEventListener("dragleave", () => dropzone.classList.remove("dragover"));
dropzone.addEventListener("drop", (e) => {
  e.preventDefault();
  dropzone.classList.remove("dragover");
  handleFiles(e.dataTransfer.files);
});

// Handle manual selection
fileInput.addEventListener("change", () => handleFiles(fileInput.files));

// Add files to our array and render list
function handleFiles(selectedFiles) {
  files = [...files, ...selectedFiles];
  renderFileList();
}

// Render file list
function renderFileList() {
  fileList.innerHTML = "";

  if (files.length > 0) {
    fileCount.textContent = `${files.length} file(s) selected`;

    // Show first 3
    files.slice(0, 3).forEach((file) => {
      const li = document.createElement("li");
      li.textContent = file.name;
      fileList.appendChild(li);
    });

    // If more than 4, show summary
    if (files.length > 4) {
      const li = document.createElement("li");
      li.textContent = `+${files.length - 3} attachment(s)`;
      fileList.appendChild(li);
    }

    clearBtn.classList.remove("d-none");
  } else {
    fileCount.textContent = "";
    clearBtn.classList.add("d-none");
  }
}

// Clear files
clearBtn.addEventListener("click", () => {
  files = [];
  fileInput.value = ""; // reset input
  renderFileList();
});

// Disable submit button on submit
form.addEventListener("submit", function () {
  submitBtn.disabled = true;
  submitText.textContent = "Submitting...";
  submitBtn.classList.add("disabled");
});
