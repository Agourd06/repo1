document.addEventListener("DOMContentLoaded", function() {
    const searchInput = document.getElementById("simple-search");
    const categoryTable = document.getElementById("categoryTable");

    searchInput.addEventListener("input", function() {
        const searchTerm = searchInput.value.trim();

        if (searchTerm.length > 0) {
            fetch("./search_category.php", {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/x-www-form-urlencoded",
                    },
                    body: `searchTerm=${encodeURIComponent(searchTerm)}`,
                })
                .then(response => response.text())
                .then(data => {
                    // Update the inner HTML of the tbody in the categoryTable
                    categoryTable.getElementsByTagName('tbody')[0].innerHTML = data;
                })
                .catch(error => {
                    console.error("Error fetching data:", error);
                });
        }
    });
});
