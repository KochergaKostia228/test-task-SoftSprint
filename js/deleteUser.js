const deleteModal = document.getElementById("deleteModal");

function deleteUser(id) {
  fetch("api/deleteUser.php", {
    method: "POST",
    headers: { "Content-Type": "application/json" },
    body: JSON.stringify({ id: id }),
  })
    .then((res) => res.json())
    .then((data) => {
      if (data.status) {
        document.querySelector(`tr[data-id="${id}"]`).remove();
      }
    });
}

deleteModal.addEventListener("show.bs.modal", function (event) {
  const userRow = event.relatedTarget.closest("tr");
  const userId = userRow.getAttribute("data-id");

  const confirmBtn = document.getElementById("confirmDeleteBtn");

  confirmBtn.onclick = function () {
    deleteUser(userId);

    const modal = bootstrap.Modal.getInstance(deleteModal);
    modal.hide();
  };
});
