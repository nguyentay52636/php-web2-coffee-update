function openAddProductModal() {
  document.getElementById("productList").classList.add("hidden");
  document.getElementById("addProductModal").classList.remove("hidden");
}
function closeAddProductModal() {
  document.getElementById("productList").classList.remove("hidden");
  document.getElementById("addProductModal").classList.add("hidden");
}

function openSuccessModal() {
  closeAddProductModal();
  document.getElementById("successProductModal").classList.remove("hidden");
  event.preventDefault();
}
function closeSuccessModal() {
  console.log("closeSuccessModal");
  document.getElementById("successProductModal").classList.add("hidden");
}

function openFailModal() {
  closeAddProductModal();
  document.getElementById("failProductModal").classList.remove("hidden");
  event.preventDefault();
}
function closeFailModal() {
  document.getElementById("failProductModal").classList.add("hidden");
}

function closeAddDiscountModal() {
  document.getElementById("addVoucher").classList.add("hidden");
  document.getElementById("discount").classList.remove("hidden");
}

function openAddDiscountModal() {
  document.getElementById("addVoucher").classList.remove("hidden");
  document.getElementById("discount").classList.add("hidden");
}
