let contactIndex = 1;

function addContact() {
    const container = document.getElementById('contacts');
    const newContactFormGroup = document.createElement('div');
    newContactFormGroup.classList.add('contact-form-group');
    newContactFormGroup.innerHTML = `
        <div class="form-group">
            <label for="contacts[${contactIndex}][name]">Kapcsolattartó neve:</label>
            <input type="text" name="contacts[${contactIndex}][name]" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="contacts[${contactIndex}][email]">Kapcsolattartó e-mail:</label>
            <input type="email" name="contacts[${contactIndex}][email]" class="form-control" required>
        </div>
        <button type="button" class="btn-remove" onclick="removeContact(this)">❌</button>
    `;
    container.appendChild(newContactFormGroup);
    contactIndex++;
}

function removeContact(button) {
    const container = document.getElementById('contacts');
    if (container.children.length > 1) {
        button.parentElement.remove();
    } else {
        alert("Legalább egy kapcsolattartónak lennie kell.");
    }
}

document.getElementById('project-form').addEventListener('submit', function(event) {
    const contacts = document.querySelectorAll('#contacts .contact-form-group');
    if (contacts.length === 0) {
        event.preventDefault();
        alert("Legalább egy kapcsolattartó megadása kötelező.");
    }
});
