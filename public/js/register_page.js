/**
 * register.js
 * Gère la validation côté client du formulaire d'inscription.
 * 
 * Principe : on intercepte la soumission du formulaire, on vérifie
 * chaque champ, et on affiche les erreurs SANS recharger la page.
 * Ce n'est que si tout est valide qu'on laisse le formulaire partir vers le serveur.
 */

// Œil ouvert  → mot de passe visible  (on peut "voir")
const SVG_EYE_OPEN = `
<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
    <path d="M16 8s-3-5.5-8-5.5S0 8 0 8s3 5.5 8 5.5S16 8 16 8zM1.173 8a13.133 13.133 0 0 1 1.66-2.043C4.12 4.668 5.88 3.5 8 3.5c2.12 0 3.879 1.168 5.168 2.457A13.133 13.133 0 0 1 14.828 8c-.058.087-.122.183-.195.288-.335.48-.83 1.12-1.465 1.755C11.879 11.332 10.119 12.5 8 12.5c-2.12 0-3.879-1.168-5.168-2.457A13.134 13.134 0 0 1 1.172 8z"/>
    <path d="M8 5.5a2.5 2.5 0 1 0 0 5 2.5 2.5 0 0 0 0-5zM4.5 8a3.5 3.5 0 1 1 7 0 3.5 3.5 0 0 1-7 0z"/>
</svg>`;
 
// Œil barré  → mot de passe masqué  (on ne peut "plus voir")
const SVG_EYE_SLASH = `
<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
    <path d="M13.359 11.238C15.06 9.72 16 8 16 8s-3-5.5-8-5.5a7.028 7.028 0 0 0-2.79.588l.77.771A5.944 5.944 0 0 1 8 3.5c2.12 0 3.879 1.168 5.168 2.457A13.134 13.134 0 0 1 14.828 8c-.058.087-.122.183-.195.288-.335.48-.83 1.12-1.465 1.755-.165.165-.337.328-.517.486l.708.709z"/>
    <path d="M11.297 9.176a3.5 3.5 0 0 0-4.474-4.474l.823.823a2.5 2.5 0 0 1 2.829 2.829l.822.822zm-2.943 1.299.822.822a3.5 3.5 0 0 1-4.474-4.474l.823.823a2.5 2.5 0 0 0 2.829 2.829z"/>
    <path d="M3.35 5.47c-.18.16-.353.322-.518.487A13.134 13.134 0 0 0 1.172 8l.195.288c.335.48.83 1.12 1.465 1.755C4.121 11.332 5.881 12.5 8 12.5c.716 0 1.39-.133 2.02-.36l.77.772A7.029 7.029 0 0 1 8 13.5C3 13.5 0 8 0 8s.939-1.721 2.641-3.238l.708.709zm10.296 8.884-12-12 .708-.708 12 12-.708.708z"/>
</svg>`;

/**
 * Marque un champ comme invalide et affiche un message d'erreur.
 * @param {string} fieldId  - l'id du champ input
 * @param {string} message  - le message à afficher
 */
function setError(fieldId, message) {
    const field = document.getElementById(fieldId);
    const error = document.getElementById(fieldId + '-error');

    field.classList.add('is-invalid');
    field.classList.remove('is-valid');

    if (error) {
        error.textContent = message;
        error.style.display = 'block';
    }
}

/**
 * Marque un champ comme valide et efface le message d'erreur.
 * @param {string} fieldId - l'id du champ input
 */
function setValid(fieldId) {
    const field = document.getElementById(fieldId);
    const error = document.getElementById(fieldId + '-error');

    field.classList.remove('is-invalid');
    field.classList.add('is-valid');

    if (error) {
        error.textContent = '';
        error.style.display = 'none';
    }
}

/**
 * Bascule entre afficher et masquer le mot de passe.
 * @param {string} inputId   - id du champ <input type="password">
 * @param {string} buttonId  - id du bouton toggle
 * @param {string} iconId    - id du <span> contenant l'icône SVG
 */
function setupToggle(inputId, buttonId, iconId) {
    document.getElementById(buttonId).addEventListener('click', function () {
        const input = document.getElementById(inputId);
        const icon  = document.getElementById(iconId);
 
        if (input.type === 'password') {
            input.type  = 'text';
            icon.innerHTML = SVG_EYE_SLASH;
        } else {
            input.type  = 'password';
            icon.innerHTML = SVG_EYE_OPEN;
        }
    });
}
 
setupToggle('mdp',        'togglePassword',        'eyeIcon');
setupToggle('mdp_confirm','togglePasswordConfirm', 'eyeIconConfirm');

/**
 * Email : vérifie le format avec une regex. Ici on vérifie
 * qu'il y a des caractères, puis un @, puis un domaine, puis un point.
 */
document.getElementById('email').addEventListener('input', function () {
    const regex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

    if (!regex.test(this.value)) {
        setError('email', 'Format d\'email invalide.');
    } else {
        setValid('email');
    }
});

/**
 * Mot de passe : vérifie la longueur minimale (8 caractères).
 * On re-vérifie aussi la confirmation si elle a déjà été remplie.
 */
document.getElementById('mdp').addEventListener('input', function () {
    if (this.value.length < 8) {
        setError('mdp', 'Le mot de passe doit contenir au moins 8 caractères.');
    } else {
        setValid('mdp');
    }

    // Si la confirmation est déjà remplie, on la re-valide immédiatement
    const confirm = document.getElementById('mdp_confirm');
    if (confirm.value.length > 0) {
        if (confirm.value !== this.value) {
            setError('mdp_confirm', 'Les mots de passe ne correspondent pas.');
        } else {
            setValid('mdp_confirm');
        }
    }
});

/**
 * Confirmation du mot de passe : vérifie qu'elle correspond au mot de passe.
 */
document.getElementById('mdp_confirm').addEventListener('input', function () {
    const mdp = document.getElementById('mdp').value;

    if (this.value !== mdp) {
        setError('mdp_confirm', 'Les mots de passe ne correspondent pas.');
    } else {
        setValid('mdp_confirm');
    }
});
/**
 * Validation a la sommission du formulaire
 */
document.getElementById('registerForm').addEventListener('submit', function (e) {
    // On bloque la soumission par défaut — on vérifie tout d'abord
    e.preventDefault();

    let isValid = true;

    const prenom = document.getElementById('prenom').value.trim();
    if (prenom === '') {
        setError('prenom', 'Le prénom est obligatoire.');
        isValid = false;
    } else {
        setValid('prenom');
    }
    
    const nom = document.getElementById('nom').value.trim();
    if (nom === '') {
        setError('nom', 'Le nom est obligatoire.');
        isValid = false;
    } else {
        setValid('nom');
    }

    const email = document.getElementById('email').value.trim();
    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    if (email === '') {
        setError('email', 'L\'email est obligatoire.');
        isValid = false;
    } else if (!emailRegex.test(email)) {
        setError('email', 'Format d\'email invalide.');
        isValid = false;
    } else {
        setValid('email');
    }

    const numTel = document.getElementById('num_tel').value.trim();
    if (numTel !== '') {
        // Accepte les formats : +32470000000, 0470 00 00 00, 0470/00.00.00, etc.
        const telRegex = /^[+\d][\d\s\/\.\-]{6,19}$/;
        if (!telRegex.test(numTel)) {
            setError('num_tel', 'Format de téléphone invalide.');
            isValid = false;
        } else {
            setValid('num_tel');
        }
    }

    const mdp = document.getElementById('mdp').value;
    if (mdp.length < 8) {
        setError('mdp', 'Le mot de passe doit contenir au moins 8 caractères.');
        isValid = false;
    } else {
        setValid('mdp');
    }

    const mdpConfirm = document.getElementById('mdp_confirm').value;
    if (mdpConfirm === '') {
        setError('mdp_confirm', 'Veuillez confirmer votre mot de passe.');
        isValid = false;
    } else if (mdpConfirm !== mdp) {
        setError('mdp_confirm', 'Les mots de passe ne correspondent pas.');
        isValid = false;
    } else {
        setValid('mdp_confirm');
    }

    if (isValid) {
        this.submit();
    }
});