
function openModal(modalId) {
    var modal = document.getElementById(modalId);
    if (modal) {
        modal.showModal();
    }
}
function closeModal(categoryId) {
    const modal = document.getElementById(`modal_${categoryId}`);
    modal.close();
}


