function addToCart(productId) {
  const formData = new FormData();
  formData.append("product_id", productId);

  fetch("", {
    method: "POST",
    body: formData,
  })
    .then((response) => response.text())
    .then((data) => {
      if (data) {
        const successMessage = document.getElementById("successMessage");
        successMessage.style.display = "block";
        successMessage.querySelector("p").textContent =
          "Produk " + data + " telah berhasil ditambahkan ke keranjang.";
      }
    })
    .catch((error) => console.error("Error:", error));
}

document.getElementById("filterButton").addEventListener("click", function () {
  document.getElementById("filterDropdown").classList.toggle("hidden");
});

document.getElementById("sortButton").addEventListener("click", function () {
  document.getElementById("sortDropdown").classList.toggle("hidden");
});
