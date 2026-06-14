document.addEventListener('click', function (e) {

    if (e.target.closest('.btn-confirm-payment')) {
        const btn       = e.target.closest('.btn-confirm-payment');
        const idEleve   = btn.dataset.eleve;
        const idSession = btn.dataset.session;

        fetch(BASE_URL + 'admin/payment/confirmPayment', {
            method  : 'POST',
            headers : { 'Content-Type': 'application/json', 'X-Requested-With': 'XMLHttpRequest' },
            body    : JSON.stringify({ id_eleve: idEleve, id_session: idSession })
        })
        .then(r => r.json())
        .then(res => {
            if (res.success) {
                const cell = document.querySelector(`#payment-row-${idEleve}-${idSession} td:last-child`);
                cell.innerHTML = '<span class="badge bg-success">Paiement Confirmé</span>';
                showToast('Paiement confirmé avec succès.', 'success');
            } else {
                showToast('Une erreur est survenue.', 'danger');
            }
        })
        .catch(() => showToast('Erreur réseau.', 'danger'));
    }
});