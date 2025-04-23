document.addEventListener("DOMContentLoaded", function() {
    const genreFilter = document.getElementById("genreFilter");
    const books = document.querySelectorAll(".book");
    const pdfViewer = document.getElementById("pdfViewer");
    const pdfIframe = document.getElementById("myIframe");
    const closeViewer = document.getElementById("closeViewer");

    // Genre filter functionality
    genreFilter.addEventListener("change", function() {
        const selectedGenre = this.value;

        books.forEach(book => {
            if (selectedGenre === "all" || book.dataset.genre === selectedGenre) {
                book.style.display = "block"; // Show matching book
            } else {
                book.style.display = "none"; // Hide non-matching book
            }
        });
    });

    // Handle the click event for the read links
    const readLinks = document.querySelectorAll(".read-link");
    readLinks.forEach(link => {
        link.addEventListener("click", function(event) {
            event.preventDefault(); // Prevent the default link behavior
            const pdfUrl = this.getAttribute("data-pdf");  
            pdfIframe.src = pdfUrl; // Set the iframe source to the PDF URL
            pdfViewer.style.display = "flex"; // Show the PDF viewer
        });
    });

    // Close the PDF viewer
    closeViewer.addEventListener("click", function() {
        pdfViewer.style.display = "none"; // Hide the PDF viewer
        pdfIframe.src = ""; // Clear the iframe source
    });

    // Search functionality with key events
    document.getElementById('searchBar').addEventListener('input', function() {
        const searchTerm = this.value.toLowerCase();

        books.forEach(book => {
            const title = book.querySelector('h3').textContent.toLowerCase();
            if (title.includes(searchTerm)) {
                book.style.display = 'block'; // Show matching book
            } else {
                book.style.display = 'none'; // Hide non-matching book
            }
        });
    });

    // Add key event listener for "Enter" key
    document.getElementById('searchBar').addEventListener('keydown', function(event) {
        if (event.key === "Enter") {
            const searchTerm = this.value.toLowerCase();

            books.forEach(book => {
                const title = book.querySelector('h3').textContent.toLowerCase();
                if (title.includes(searchTerm)) {
                    book.style.display = 'block'; // Show matching book
                } else {
                    book.style.display = 'none'; // Hide non-matching book
                }
            });
        }
    });
});
