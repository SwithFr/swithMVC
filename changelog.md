# changelog à la va vite

#12/08/15 : 
 - création de la session dès le début et non plus dans le constructeur du controller
 - Ajout du token automatiquement après soumission du formulaire
 - CSRFTool : check aussi si le token est en POST

## /!\ AVANT /!\
##AUTH
virer les espace dans Auth
if isset role dans Auth pour login
role() faire un isset
refactor pour crypter mdp

##HELPERS
ajouter meta dans HTML
modifier link pour utiliser routes
Ajouter token dans link

##MODEL
setNeedEntity
needEntity à nul et non false par défaut
ajouter méthode exist

##ROUTER
isset params_url dans Router

##SWITH
ajouter commande views

##VALIDATOR
ajouter isUnique dans validator
ajouter EqualsTo

Date ajouter methodes
Ajouter CSRFTool

##VENDOR
ajouter un param pour montrer ou non le backtrace dans SwithError
