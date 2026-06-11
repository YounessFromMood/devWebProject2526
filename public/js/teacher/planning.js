(function () {
    // IIFE : toutes les variables vivent ici, pas dans le scope global.
    // Le script peut donc être réinjecté plusieurs fois sans erreur de redéclaration.

    const grid = document.getElementById('calendarGrid');
    if (!grid) return; // sécurité : si la section n'est pas chargée, on ne fait rien

    const sessions = JSON.parse(grid.dataset.sessions || '[]');
    let currentDate = new Date();

    // Construit "YYYY-MM-DD" à partir de la date LOCALE
    // (toISOString() convertit en UTC et décale d'un jour en Belgique)
    function toLocalDateStr(d) {
        const y = d.getFullYear();
        const m = String(d.getMonth() + 1).padStart(2, '0');
        const day = String(d.getDate()).padStart(2, '0');
        return `${y}-${m}-${day}`;
    }

    function buildCalendar(year, month) {
        const monthNames = ['Janvier','Février','Mars','Avril','Mai','Juin',
                            'Juillet','Août','Septembre','Octobre','Novembre','Décembre'];
        document.getElementById('calendarTitle').textContent = monthNames[month] + ' ' + year;

        const firstDay = new Date(year, month, 1);
        const lastDay  = new Date(year, month + 1, 0);

        let html = '<table class="table table-bordered text-center"><thead><tr>';
        ['Lun','Mar','Mer','Jeu','Ven'].forEach(d => html += `<th>${d}</th>`);
        html += '</tr></thead><tbody>';

        // On remonte jusqu'au lundi de la semaine du 1er du mois
        let cursor = new Date(firstDay);
        const dayOfWeek = cursor.getDay(); // 0 = dimanche, 1 = lundi...
        const offset = dayOfWeek === 0 ? -6 : 1 - dayOfWeek;
        cursor.setDate(cursor.getDate() + offset);

        while (cursor <= lastDay) {
            html += '<tr>';
            for (let i = 0; i < 5; i++) { // lundi à vendredi
                const isCurrentMonth = cursor.getMonth() === month;
                const dateStr = toLocalDateStr(cursor); // date locale, plus de décalage UTC

                // Sessions actives ce jour-là (les dates SQL sont déjà au format YYYY-MM-DD)
                const daySessions = sessions.filter(s =>
                    s.date_debut <= dateStr && s.date_fin >= dateStr
                );

                const cellContent = daySessions.map(s =>
                    `<div class="rounded px-1 text-white small"
                        style="background-color:#e8630a;"
                        title="${s.formation_titre}">
                        <div class="fw-bold">${s.formation_titre}</div>
                        <div>${s.modalite_libelle}</div>
                        <div>${s.lieu_session ?? '—'}</div>
                    </div>`
                ).join('');

                const textClass = isCurrentMonth ? '' : 'text-muted';
                const bgStyle   = isCurrentMonth ? '' : 'background-color:#f8f9fa;';

                html += `<td style="min-width:100px; vertical-align:top; ${bgStyle}">
                            <div class="${textClass} fw-bold small mb-1">${cursor.getDate()}</div>
                            ${cellContent}
                         </td>`;

                cursor.setDate(cursor.getDate() + 1);
            }
            // On saute samedi et dimanche
            cursor.setDate(cursor.getDate() + 2);
            html += '</tr>';
        }

        html += '</tbody></table>';
        grid.innerHTML = html;
    }

    buildCalendar(currentDate.getFullYear(), currentDate.getMonth());

    document.getElementById('btnPrevMonth').addEventListener('click', function () {
        currentDate.setMonth(currentDate.getMonth() - 1);
        buildCalendar(currentDate.getFullYear(), currentDate.getMonth());
    });

    document.getElementById('btnNextMonth').addEventListener('click', function () {
        currentDate.setMonth(currentDate.getMonth() + 1);
        buildCalendar(currentDate.getFullYear(), currentDate.getMonth());
    });
})();