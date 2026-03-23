# Tests Selenium IDE - BTS-SYMFONY-TP_Cine

Ce dossier contient une suite complète de fichiers `.side` pour tester l'application BTS-SYMFONY-TP_Cine avec Selenium IDE.

## 📋 Fichiers de test disponibles

### 1. **test-home-and-navigation.side**
Tests pour la page d'accueil et la navigation générale
- Test de la page d'accueil (`/`)
- Navigation vers les films
- Navigation vers les favoris
- Navigation vers le contact

### 2. **test-authentication.side**
Tests pour l'authentification et l'authentification
- Accès à la page de connexion
- Connexion avec des identifiants invalides
- Connexion avec des identifiants valides
- Déconnexion

### 3. **test-movies.side**
Tests pour les routes liées aux films
- Affichage de la liste des films (`/movies`)
- Recherche de films
- Affichage des détails d'un film (`/movies/{id}`)
- Sauvegarde d'un film en base de données (`/save_movie/{id}`)
- Partage d'un film par email (`/mail`)

### 4. **test-movie-crud.side**
Tests pour les opérations CRUD sur les films
- Affichage de la liste CRUD (`/movie/crud`)
- Création d'un nouveau film (`/movie/crud/new`)
- Affichage des détails d'un film (`/movie/crud/{id}`)
- Modification d'un film (`/movie/crud/{id}/edit`)
- Suppression d'un film
- Filtrage des films par année (`/movie/crud/findBefore/{year}`)

### 5. **test-ratings.side**
Tests pour les évaluations de films
- Affichage de la liste des évaluations (`/rating`)
- Création d'une nouvelle évaluation (`/rating/new`)
- Affichage des détails d'une évaluation (`/rating/{id}`)
- Modification d'une évaluation (`/rating/{id}/edit`)
- Suppression d'une évaluation

### 6. **test-collections.side**
Tests pour les collections de films
- Affichage de la liste des collections (`/collections`)
- Création d'une nouvelle collection (`/collections/new`)
- Recherche de films pour une collection
- Affichage des détails d'une collection (`/collections/{id}`)
- Modification d'une collection (`/collections/{id}/edit`)
- Suppression d'une collection

### 7. **test-favorites-contact.side**
Tests pour les favoris et le formulaire de contact
- Affichage de la page des favoris (`/favorites`)
- Ajout d'un film aux favoris
- Affichage de la page de contact (`/contact`)
- Soumission du formulaire de contact

### 8. **test-all-routes.side**
Suite complète de test de toutes les routes
- Test rapide de chaque route principale

## 🚀 Installation et utilisation

### Prérequis
- **Selenium IDE** : [Extension Chrome/Firefox](https://www.selenium.dev/selenium-ide/)
- Application en cours d'exécution sur `http://localhost` (ou modifier l'URL de base)

### Étapes d'utilisation

1. **Installer Selenium IDE**
   - Téléchargez l'extension depuis le Chrome Web Store ou Firefox Add-ons

2. **Importer les fichiers de test**
   - Ouvrez Selenium IDE
   - Cliquez sur "Open" → "Open project"
   - Sélectionnez un fichier `.side`

3. **Configurer l'URL de base** (si nécessaire)
   - Modifiez l'URL de base dans les tests (ex: remplacez `http://localhost` par votre URL)

4. **Exécuter les tests**
   - Cliquez sur "Run all tests" pour exécuter tous les tests d'une suite
   - Cliquez sur "Run" pour exécuter un test individuel

## 📝 Structure des tests

Chaque test contient :
- **open** : Navigue vers une page
- **waitForElementVisible** : Attend qu'un élément soit visible
- **type** : Saisit du texte dans un champ
- **click** : Clique sur un bouton ou lien
- **verifyElementPresent** : Vérifie la présence d'un élément
- **assertTitle** : Vérifie le titre de la page

## 🔧 Sélecteurs CSS utilisés

Les sélecteurs utilisent des patterns généraux :
- `.movie-list`, `.movies` : Listes de films
- `.form`, `form[method='POST']` : Formulaires
- `button[type='submit']` : Boutons de soumission
- `input[name*='query']` : Champs de recherche
- `.alert.alert-success` : Messages de succès

**Note** : Adapter les sélecteurs selon la structure HTML réelle de votre application.

## ⚙️ Configuration des identifiants

Avant de lancer les tests d'authentification, mettez à jour les identifiants dans `test-authentication.side` :

```json
"type",
"target": "css=input[name='_username']",
"value": "votre_email@example.com"  // À adapter

"type",
"target": "css=input[name='_password']",
"value": "votre_mot_de_passe"  // À adapter
```

## 📌 Conseils et astuces

1. **Attendre les éléments** : Utilisez les temps d'attente (`waitForElementVisible`) suffisamment longs pour les opérations asynchrones
2. **Erreurs de sélecteurs** : Si un test échoue, vérifiez que les sélecteurs CSS correspondant à votre markup HTML
3. **Tests parallèles** : Les tests sont configurés en mode séquentiel (`persistSession: false`)
4. **Logs** : Consultez la console du navigateur pour les erreurs
5. **Screenshots** : Activez les screenshots en cas d'erreur pour déboguer

## 🐛 Dépannage

| Problème | Solution |
|----------|----------|
| Les tests ne trouvent pas les éléments | Vérifier les sélecteurs CSS avec l'inspecteur du navigateur |
| Erreur de connexion | Vérifier que l'application est en cours d'exécution |
| Délais d'expiration | Augmenter la valeur de `waitForElementVisible` |
| CSRF token invalide | Vérifier que les sessions sont correctement gérées |

## 📚 Ressources

- [Documentation Selenium IDE](https://www.selenium.dev/selenium-ide/)
- [Sélecteurs CSS](https://developer.mozilla.org/en-US/docs/Learn_web_development/Extensions/CSS_selectors)
- [Format fichier .side](https://www.selenium.dev/selenium-ide/docs/en/introduction/command-line-runner)

---

**Dernière mise à jour** : 23 mars 2026
**Version** : 1.0
