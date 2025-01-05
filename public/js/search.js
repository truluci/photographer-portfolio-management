document.addEventListener("DOMContentLoaded", function () {
    const searchInput = document.getElementById("searchInput");
    const photoCards = document.querySelectorAll(".photos div");

    searchInput.addEventListener("input", function () {
        const searchQuery = searchInput.value.toLowerCase().trim();

        photoCards.forEach((card) => {
            const title = card.querySelector("p:nth-of-type(1)").textContent.toLowerCase();
            const description = card.querySelector("p:nth-of-type(2)").textContent.toLowerCase();

            if (title.includes(searchQuery) || description.includes(searchQuery)) {
                card.style.display = "block";
            } else {
                card.style.display = "none";
            }
        });
    });
});
