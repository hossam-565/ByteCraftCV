var selectedTemplate = null;

function selectTemplate(template) {
    selectedTemplate = template;
    document.getElementById('nextButton').disabled = false;
}

function nextPage() {
    if (selectedTemplate) {
        // Redirection en fonction du template sélectionné
        if (selectedTemplate == 'Blue_formulaire') {
            window.location.href = 'Blue_formulaire.php';
        } else if (selectedTemplate == 'Black_formulaire') {
            window.location.href = 'Black_formulaire.php';
        } else {
            console.log('Template non valide');
        }
    } else {
        console.log('Aucun template sélectionné');
    }
}
