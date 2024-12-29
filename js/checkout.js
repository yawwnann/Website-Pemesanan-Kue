document.getElementById("payButton").addEventListener("click", function () {
  // Kirimkan form checkout untuk mendapatkan token Snap
  fetch("process_checkout.php", {
    method: "POST",
    body: new FormData(document.getElementById("checkoutForm")),
  })
    .then((response) => response.json())
    .then((data) => {
      if (data.snap_token) {
        window.snap.pay(data.snap_token, {
          onSuccess: function (result) {
            // Redirect ke halaman pesanan_status.php setelah pembayaran berhasil
            alert("Pembayaran berhasil!");
            window.location.href =
              "show_products.php?order_id=" + result.order_id;
          },
          onPending: function (result) {
            alert("Pembayaran tertunda. Silakan periksa statusnya.");
            window.location.href =
              "show_products.php?order_id=" + result.order_id;
          },
          onError: function (result) {
            alert("Terjadi kesalahan dalam proses pembayaran.");
            window.location.href = "error.php";
          },
        });
      } else {
        alert("Gagal mendapatkan token pembayaran.");
      }
    })
    .catch((error) => {
      alert("Terjadi kesalahan saat menghubungkan dengan server.");
    });
});
