# changelog à la va vite

#12/08/15 : 
 - création de la session dès le début et non plus dans le constructeur du controller
 - Ajout du token automatiquement après soumission du formulaire
 - CSRFTool : check aussi si le token est en POST

## /!\ AVANT /!\
- virer les espace dans Auth
- if isset role dans Auth pour login
- role() faire un isset
- refactor pour crypter mdp
- ajouter meta dans HTML
- modifier link pour utiliser routes
- Ajouter token dans link
- setNeedEntity
- needEntity à nul et non false par défaut
- ajouter méthode exist
- isset params_url dans Router
- ajouter commande views
- ajouter isUnique dans validator
- ajouter EqualsTo
- Date ajouter methodes
- Ajouter CSRFTool
- ajouter un param pour montrer ou non le backtrace dans SwithError
