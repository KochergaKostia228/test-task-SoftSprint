const errorOptionsModalBody = document.getElementById("errorOptionsModalBody");

function fetchSelectedUsers(ids, status) {
  fetch("api/editStatusUsers.php", {
    method: "POST",
    headers: { "Content-Type": "application/json" },
    body: JSON.stringify({
      ids: ids,
      status: status === "active" ? 1 : 2,
    }),
  })
    .then((response) => response.json())
    .then((data) => {
      if (data.status) {
        ids.forEach((id) => {
          const userRow = document.querySelector(`tr[data-id="${id}"]`);
          if (userRow) {
            const statusCell = userRow.querySelector(".status");
            if (statusCell) {
              statusCell.textContent =
                status === "active" ? "active" : "inactive";
            }
          }
        });
      }
    });
}

function deleteSelectedUsers(ids) {
  fetch("api/deleteUsers.php", {
    method: "POST",
    headers: { "Content-Type": "application/json" },
    body: JSON.stringify({ ids: ids }),
  })
    .then((response) => response.json())
    .then((data) => {
      if (data.status) {
        data.ids.forEach((id) => {
          const userRow = document.querySelector(`tr[data-id="${id}"]`);
          if (userRow) {
            userRow.remove();
          }
        });
      }
    });
}

document.querySelectorAll(".options-block").forEach((block) => {
  const optionsBtn = block.querySelector(".optionsBtn");

  const optionsSelector = block.querySelector(".optionsSelector");

  optionsBtn.addEventListener("click", () => {
    const selectedOption = optionsSelector.value;

    const modalElement = document.getElementById("optionsErrorModal");

    if (!selectedOption) {
      if (errorOptionsModalBody) {
        errorOptionsModalBody.textContent = "Please select an option.";
      }

      if (!modalElement) return;

      bootstrap.Modal.getOrCreateInstance(modalElement).show();

      return;
    }

    const selectedUserIds = Array.from(
      document.querySelectorAll(".row-check:checked"),
    )
      .map((cb) => cb.closest("tr")?.dataset.id)
      .filter(Boolean);

    if (selectedUserIds.length === 0) {
      if (errorOptionsModalBody) {
        errorOptionsModalBody.textContent = "Please select at least one user.";
      }

      if (!modalElement) return;

      bootstrap.Modal.getOrCreateInstance(modalElement).show();

      return;
    }

    console.log(selectedOption, selectedUserIds);

    if (selectedOption === "delete") {
      const modalElement = document.getElementById("deleteItemsModal");
      const confirmBtn = document.getElementById("confirmDeleteItemsBtn");

      if (!modalElement) return;

      bootstrap.Modal.getOrCreateInstance(modalElement).show();

      confirmBtn.onclick = function () {
        deleteSelectedUsers(selectedUserIds);
        const modal = bootstrap.Modal.getInstance(modalElement);
        modal.hide();
      };
    } else {
      fetchSelectedUsers(selectedUserIds, selectedOption);
    }
  });
});
