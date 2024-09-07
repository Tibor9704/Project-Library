
function submitForm() {
    document.getElementById('status-filter-form').submit();
}

var deleteModal = document.getElementById('deleteModal');
deleteModal.addEventListener('show.bs.modal', function (event) {
    var button = event.relatedTarget;
    var projectId = button.getAttribute('data-id');
    var projectName = button.getAttribute('data-name');
    
    var modalBodyName = deleteModal.querySelector('#projectName');
    modalBodyName.textContent = projectName;

    var form = deleteModal.querySelector('#delete-form');
    form.action = '/projects/' + projectId;
});

