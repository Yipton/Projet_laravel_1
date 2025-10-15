<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <meta name="description" content="Application de gestion du concours de robots des collèges (Deux-Sèvres) : inscriptions, saisie des notes, résultats et informations générales." />
  <link href="/css/pico.css" rel="stylesheet" />
  <link href="/css/styles.css" rel="stylesheet" />
  <title>Accueil — Projet concours-robots</title>
</head>
<body>
  <div class="wrapper">
    <?php include 'header.html';?>

    <main class="container">
      <!-- HERO -->
      <section aria-labelledby="hero-title" style="margin-top:1rem">
        <article class="grid" style="align-items:center">
          <div>
            <h1 id="hero-title">Projet concours-robots</h1>
            <p class="contrast">
              Application web de gestion du concours (inscriptions, saisie des épreuves, classements).
              Édition 2025 tenue le <strong>vendredi 5 avril 2025</strong> à Valette (9h–15h).
            </p>
            <nav>
              <a role="button" class="primary" href="/inscriptions">Inscrire une équipe</a>
              <a role="button" href="/resultats">Voir les résultats</a>
              <a role="button" href="/informations">Infos &amp; règlement</a>
            </nav>
          </div>

          <figure>
            <img
              src="./images/robot.jpg"
              alt="Robot de compétition sur une piste"
              loading="eager"
              decoding="async"
              style="width:100%;height:auto;border-radius:1rem"
            />
            <figcaption class="secondary">Concours des collèges — Technologie 3<sup>e</sup></figcaption>
          </figure>
        </article>
      </section>

      <!-- RÉSUMÉ RAPIDE -->
      <section aria-labelledby="about-title">
        <h2 id="about-title">À quoi sert le site ?</h2>
        <div class="grid">
          <article>
            <h3>Avant le concours</h3>
            <p>Les enseignants créent les comptes et <strong>inscrivent les équipes</strong> (code collège + numéro, ex. <code>ND01</code>).</p>
          </article>
          <article>
            <h3>Pendant le concours</h3>
            <p>Les jurys notent, les secrétaires <strong>saisissent les notes</strong>. Les équipes consultent <em>leurs</em> résultats en direct.</p>
          </article>
          <article>
            <h3>Après le concours</h3>
            <p><strong>Classements</strong> par catégories, export <code>CSV/ODS/XLS</code> envoyés aux enseignants.</p>
          </article>
        </div>
      </section>

      <!-- ACCÈS RAPIDES -->
      <section aria-labelledby="quicklinks-title">
        <h2 id="quicklinks-title">Accès rapides</h2>
        <ul>
          <li><a href="/connexion">Se connecter</a> / <a href="/inscription">Créer un compte</a></li>
          <li><a href="/saisie">Saisie des résultats (secrétariat)</a></li>
          <li><a href="/epreuves">Épreuves &amp; barèmes</a></li>
          <li><a href="/mentions-legales">Mentions légales &amp; RGPD</a></li>
        </ul>
      </section>
    </main>

    <?php include 'footer.html';?>
  </div>
</body>
</html>
