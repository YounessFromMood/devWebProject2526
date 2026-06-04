/**
 * Sert à basculer la visibilité du mot de passe et à valider le format de l'email en temps réel.
 */
document.getElementById('togglePassword').addEventListener('click', function () {
    const input = document.getElementById('mdp');
    const icon = document.getElementById('eyeIcon');

    if (input.type === 'password') {
        input.type = 'text';
        icon.classList.replace('ti-eye', 'ti-eye-off');
    } else {
        input.type = 'password';
        icon.classList.replace('ti-eye-off', 'ti-eye');
    }
});
/**
 * Valide le format de l'email en temps réel et applique les classes CSS appropriées pour indiquer si l'email est valide ou non.
 */
document.getElementById('email').addEventListener('input', function () {
    const regex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

    if (!regex.test(this.value)) {
        this.classList.add('is-invalid');
        this.classList.remove('is-valid');
    } else {
        this.classList.remove('is-invalid');
        this.classList.add('is-valid');
    }
});