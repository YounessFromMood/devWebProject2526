<?php
/**
 * Politique de confidentialité (conforme RGPD)
 * Vue à placer dans : app/Views/legal/confidentialite.php
 *
 * NB : texte GÉNÉRIQUE adapté aux données réellement collectées par le site
 *      (nom, prénom, email, téléphone, mot de passe haché, inscriptions,
 *       paiements, notes, cookies "remember").
 *      Remplace les éléments entre [crochets] par tes vraies infos.
 */
?>
<?= $this->include('includes/header') ?>

<div class="container my-5" style="max-width: 900px;">

    <h1 class="fw-bold mb-1" style="color: #e8630a;">Politique de confidentialité</h1>
    <p class="text-muted mb-4">Dernière mise à jour : <?= date('d/m/Y') ?></p>

    <div class="card border-0 shadow-sm">
        <div class="card-body p-4 p-md-5">

            <p>
                La présente politique explique quelles données personnelles le site
                <strong>En Formation!</strong> collecte, pourquoi, comment elles sont
                utilisées et quels sont vos droits. Elle est conforme au Règlement Général
                sur la Protection des Données (RGPD - Règlement UE 2016/679).
            </p>

            <h2 class="h5 fw-bold mt-4">1. Responsable du traitement</h2>
            <p>
                Le responsable du traitement des données est :
                <br><strong>[Nom de la structure]</strong>, [adresse complète],
                joignable à l'adresse <strong>[adresse e-mail de contact]</strong>.
            </p>

            <h2 class="h5 fw-bold mt-4">2. Données collectées</h2>
            <p>Dans le cadre de l'utilisation du Site, nous collectons :</p>
            <ul>
                <li><strong>Données d'identité</strong> : nom et prénom ;</li>
                <li><strong>Données de contact</strong> : adresse e-mail et, facultativement, numéro de téléphone ;</li>
                <li><strong>Données de connexion</strong> : mot de passe (stocké de façon <em>hachée</em>, donc illisible même par nous) ;</li>
                <li><strong>Données d'activité</strong> : inscriptions aux sessions, statut de paiement, dates d'inscription, historique de formations et notes/résultats obtenus.</li>
            </ul>

            <h2 class="h5 fw-bold mt-4">3. Finalités du traitement</h2>
            <p>Ces données sont utilisées pour :</p>
            <ul>
                <li>créer et gérer votre compte utilisateur ;</li>
                <li>gérer vos inscriptions aux sessions et le suivi des paiements ;</li>
                <li>vous donner accès à votre historique de formations et à vos résultats ;</li>
                <li>permettre aux formateurs et administrateurs d'assurer le suivi pédagogique ;</li>
                <li>vous contacter en lien avec vos formations.</li>
            </ul>

            <h2 class="h5 fw-bold mt-4">4. Base légale</h2>
            <p>
                Le traitement repose principalement sur l'<strong>exécution du contrat</strong>
                (votre inscription à une formation) et, pour les données facultatives ou les
                cookies non essentiels, sur votre <strong>consentement</strong>.
            </p>

            <h2 class="h5 fw-bold mt-4">5. Destinataires des données</h2>
            <p>
                Vos données ne sont accessibles qu'aux personnes habilitées dans le cadre du
                fonctionnement du Site : les <strong>administrateurs</strong> (gestion des
                comptes, des paiements et des formations) et les <strong>formateurs</strong>
                (suivi des élèves de leurs sessions). Elles ne sont ni vendues, ni louées,
                ni transmises à des tiers à des fins commerciales.
            </p>

            <h2 class="h5 fw-bold mt-4">6. Durée de conservation</h2>
            <p>
                Vos données sont conservées tant que votre compte est actif. À la suppression
                de votre compte, elles sont supprimées ou anonymisées dans un délai raisonnable,
                sauf obligation légale de conservation plus longue (par exemple, conservation
                des justificatifs comptables liés aux paiements).
            </p>

            <h2 class="h5 fw-bold mt-4">7. Sécurité</h2>
            <p>
                Nous mettons en œuvre des mesures techniques pour protéger vos données :
                hachage des mots de passe, accès restreint aux personnes autorisées et
                contrôle des sessions de connexion. Aucun système n'étant infaillible, nous ne
                pouvons toutefois garantir une sécurité absolue.
            </p>

            <h2 class="h5 fw-bold mt-4">8. Cookies</h2>
            <p>
                Le Site utilise des cookies strictement nécessaires à son fonctionnement
                (maintien de votre session de connexion). Si vous activez l'option « se souvenir
                de moi », un cookie d'authentification est conservé sur votre appareil jusqu'à
                son expiration. Ces cookies essentiels ne nécessitent pas de consentement.
            </p>

            <h2 class="h5 fw-bold mt-4">9. Vos droits</h2>
            <p>Conformément au RGPD, vous disposez des droits suivants :</p>
            <ul>
                <li><strong>Droit d'accès</strong> : savoir quelles données nous détenons sur vous ;</li>
                <li><strong>Droit de rectification</strong> : corriger des données inexactes ;</li>
                <li><strong>Droit à l'effacement</strong> (« droit à l'oubli ») : demander la suppression de vos données ;</li>
                <li><strong>Droit à la limitation</strong> du traitement ;</li>
                <li><strong>Droit d'opposition</strong> au traitement ;</li>
                <li><strong>Droit à la portabilité</strong> : récupérer vos données dans un format réutilisable.</li>
            </ul>
            <p>
                Pour exercer ces droits, contactez-nous à <strong>[adresse e-mail de contact]</strong>.
                Nous répondons dans un délai d'un mois.
            </p>

            <h2 class="h5 fw-bold mt-4">10. Réclamation</h2>
            <p>
                Si vous estimez que vos droits ne sont pas respectés, vous pouvez introduire une
                réclamation auprès de l'autorité de contrôle belge :
                <strong>l'Autorité de protection des données (APD)</strong> —
                <a href="https://www.autoriteprotectiondonnees.be" target="_blank" rel="noopener" style="color: #e8630a;">www.autoriteprotectiondonnees.be</a>.
            </p>

            <h2 class="h5 fw-bold mt-4">11. Modifications</h2>
            <p>
                Cette politique peut être mise à jour. La date de dernière mise à jour figure en
                haut de page. Nous vous invitons à la consulter régulièrement.
            </p>

        </div>
    </div>
</div>

<?= $this->include('includes/footer') ?>