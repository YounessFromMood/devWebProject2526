<?php
/**
 * Conditions Générales d'Utilisation (CGU)
 * Ici il s'agit d'un projet fictif
 * Les données de contact et l'adresses sont fictives également
 */
?>
<?= $this->include('includes/header') ?>

<div class="container my-5" style="max-width: 900px;">

    <h1 class="fw-bold mb-1" style="color: #e8630a;">Conditions Générales d'Utilisation</h1>
    <p class="text-muted mb-4">Dernière mise à jour : <?= date('d/m/Y') ?></p>

    <div class="card border-0 shadow-sm">
        <div class="card-body p-4 p-md-5">

            <h2 class="h5 fw-bold mt-2">1. Objet</h2>
            <p>
                Les présentes Conditions Générales d'Utilisation (ci-après « les CGU »)
                définissent les règles d'accès et d'utilisation du site
                <strong>En Formation!</strong> (ci-après « le Site »), une plateforme de
                gestion et d'inscription à des formations en ligne ou en présentiel.
                Toute utilisation du Site implique l'acceptation pleine et entière des présentes CGU.
            </p>

            <h2 class="h5 fw-bold mt-4">2. Accès au Site</h2>
            <p>
                Le Site est accessible gratuitement à tout utilisateur disposant d'un accès
                à Internet. Certaines fonctionnalités (inscription à une session, accès au
                tableau de bord, consultation de l'historique des formations) nécessitent la
                création d'un compte personnel.
            </p>
            <p>
                L'éditeur du Site s'efforce d'assurer un accès continu, mais ne peut être tenu
                responsable d'une interruption, qu'elle soit due à une maintenance, une panne
                technique ou un cas de force majeure.
            </p>

            <h2 class="h5 fw-bold mt-4">3. Création de compte</h2>
            <p>
                Pour s'inscrire, l'utilisateur fournit des informations exactes (nom, prénom,
                adresse e-mail et, éventuellement, numéro de téléphone). L'utilisateur est
                responsable de la confidentialité de son mot de passe et de toute activité
                réalisée depuis son compte. En cas d'utilisation non autorisée, il s'engage à
                en informer immédiatement l'éditeur.
            </p>

            <h2 class="h5 fw-bold mt-4">4. Inscription aux formations et paiement</h2>
            <p>
                L'utilisateur peut s'inscrire aux sessions de formation disponibles, dans la
                limite des places. Après inscription, le montant, les coordonnées de paiement et
                la référence à indiquer lui sont communiqués. L'inscription n'est confirmée
                qu'une fois le paiement reçu et validé par un administrateur.
            </p>
            <p>
                En cas de désistement avant le début de la session, un remboursement partiel
                peut être appliqué : le pourcentage remboursé dépend du délai entre la date du
                désistement et la date de début de la session (plus le désistement est anticipé,
                plus le pourcentage est élevé).
            </p>

            <h2 class="h5 fw-bold mt-4">5. Comportement de l'utilisateur</h2>
            <p>L'utilisateur s'engage à ne pas :</p>
            <ul>
                <li>utiliser le Site à des fins illégales ou frauduleuses ;</li>
                <li>tenter de perturber le fonctionnement du Site ou sa sécurité ;</li>
                <li>usurper l'identité d'un autre utilisateur ;</li>
                <li>diffuser des contenus illicites, injurieux ou portant atteinte aux droits de tiers.</li>
            </ul>

            <h2 class="h5 fw-bold mt-4">6. Propriété intellectuelle</h2>
            <p>
                L'ensemble des contenus du Site (textes, logos, mise en page, contenus de
                formation) est protégé par le droit de la propriété intellectuelle. Toute
                reproduction ou utilisation sans autorisation préalable est interdite.
            </p>

            <h2 class="h5 fw-bold mt-4">7. Données personnelles</h2>
            <p>
                Le traitement des données personnelles est décrit en détail dans notre
                <a href="<?= base_url('/confidentialite') ?>" style="color: #e8630a;">Politique de confidentialité</a>,
                conforme au Règlement Général sur la Protection des Données (RGPD).
            </p>

            <h2 class="h5 fw-bold mt-4">8. Responsabilité</h2>
            <p>
                Le Site est fourni « en l'état ». L'éditeur ne saurait être tenu responsable des
                dommages directs ou indirects résultant de l'utilisation du Site ou de
                l'impossibilité d'y accéder.
            </p>

            <h2 class="h5 fw-bold mt-4">9. Modification des CGU</h2>
            <p>
                L'éditeur se réserve le droit de modifier les présentes CGU à tout moment. Les
                utilisateurs sont invités à les consulter régulièrement. La version applicable
                est celle en vigueur au moment de la connexion.
            </p>

            <h2 class="h5 fw-bold mt-4">10. Droit applicable</h2>
            <p>
                Les présentes CGU sont régies par le droit belge. En cas de litige, et à défaut
                de résolution amiable, les tribunaux compétents seront ceux du ressort de
                l'éditeur.
            </p>

            <hr class="my-4">
            <p class="text-muted mb-0" style="font-size: 14px;">
                Éditeur : En Formation! ASBL — Rue de la Rue 1, 7170 La Louvière — Contact : contact@enformation.be
            </p>

        </div>
    </div>
</div>

<?= $this->include('includes/footer') ?>