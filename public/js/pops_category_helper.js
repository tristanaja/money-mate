function toggleAddCategory() {
  const modal = document.getElementById("addCategoryModal");
  modal.classList.toggle("hidden");
}

// function toggleEditCategory(id, name) {
//   document.getElementById("editCategoryId").value = id;
//   document.getElementById("editCategoryName").value = name;
//   const modal = document.getElementById("editCategoryModal");
//   modal.classList.toggle("hidden");
// }

document.addEventListener("DOMContentLoaded", () => {
  const editBtn = document.getElementById("addCategoryButton");
  editBtn.addEventListener("click", toggleAddCategory);
});
