document.addEventListener('DOMContentLoaded', function () {

    const formInfos = document.getElementById('form-infos');
    const formPhoto = document.getElementById('form-photo');

    function notifier(message, success) {
        if (typeof showToast === 'function') {
            showToast(message, success ? 'success' : 'danger');
        } else {
            alert(message);
        }
    }

    function rafraichirCsrf(data) {
        if (data && data.csrf) {
            document.querySelectorAll('.csrf-token').forEach(function (input) {
                input.value = data.csrf;
            });
        }
    }

    function envoyer(url, formData, onSuccess) {
        fetch(url, {
            method  : 'POST',
            headers : { 'X-Requested-With': 'XMLHttpRequest' },
            body    : formData
        })
        .then(function (r) {
            return r.text().then(function (text) {
                let data = {};
                try { data = JSON.parse(text); } catch (e) {}
                return { status: r.status, data: data, text: text };
            });
        })
        .then(function (res) {
            rafraichirCsrf(res.data);

            if (res.data.success) {
                notifier(res.data.message, true);
                onSuccess(res.data);
            } else {
                let msg = res.data.message
                    || (res.data.messages && (res.data.messages.error || Object.values(res.data.messages)[0]))
                    || ('Erreur serveur (code ' + res.status + ')');
                notifier(msg, false);
            }
        })
        .catch(function () { notifier('Erreur reseau.', false); });
    }

    if (formInfos) {
        formInfos.addEventListener('submit', function (e) {
            e.preventDefault();
            envoyer(BASE_URL + 'profile/update-info', new FormData(formInfos), function () {
                formInfos.querySelector('input[name="mdp"]').value = '';
                document.getElementById('profil-prenom').textContent = formInfos.prenom.value;
                document.getElementById('profil-nom').textContent    = formInfos.nom.value;
            });
        });
    }

    if (formPhoto) {
        formPhoto.addEventListener('submit', function (e) {
            e.preventDefault();
            envoyer(BASE_URL + 'profile/update-photo', new FormData(formPhoto), function (data) {
                if (data.url) {
                    const img = document.getElementById('apercu-photo');
                    const ini = document.getElementById('apercu-initiales');
                    img.src = data.url + '?t=' + Date.now();
                    img.classList.remove('d-none');
                    if (ini) ini.classList.add('d-none');
                }
            });
        });
    }

});