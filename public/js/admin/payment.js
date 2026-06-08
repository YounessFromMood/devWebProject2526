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
                document.getElementById(`payment-row-${idEleve}-${idSession}`).remove();
                showToast('Paiement confirmé avec succès.', 'success');

                const tbody = document.querySelector('#dataTablePayments tbody');
                if (tbody && tbody.querySelectorAll('tr').length === 0) {
                    showToast('Aucun paiement en attente.', 'danger');
                    loadSection('paiements', document.querySelector('[data-section="paiements"]'));
                }
            } else {
                showToast('Une erreur est survenue.', 'danger');
            }
        })
        .catch(() => showToast('Erreur réseau.', 'danger'));
    }
});