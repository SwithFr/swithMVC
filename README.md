#Swith MVC qu'est-ce que c'est ?

Dans le but d'approfondir mes connaissances en PHP et en programmation orientée objet, j'ai décidé de développer mon propre framework MVC.
En effet, j'ai d'abord commencé par utiliser CakePhp, puis Laravel, et je me suis dis que lire une documentation c'est plutot facile, mais comprendre comment ça fonctionne sous le capot c'est autre chose. L'idée est donc partie de là. Alors évidement dans ce ridicule framework, on retrouve une large inspiration des MVC existants, surtout de CakePhp. 

Donc voilà, c'est mon framework, sans prétention, simple, mais il fonctionne ! 

##Philosophie 

Mon but premier est de réaliser non pas un framework complet, mais un framework simple et logique d'utilisation. Il est destiné aux personnes qui, comme moi, souhaitent découvrir comment est construit un framework, comment fonctionne son Core. Alors évidement il n'est pas bourré de dépendances, de facades, d'interfaces etc. qui rendraient la lecture du Core plus difficile car on se perdrait vite entre les différents fichiers. Non, je veux quelques chose de simple plutot que d'optimisé ! Cela ne veut pas non plus dire, que je fais ça n'importe comment ! Je cherche tout de même à avoir un code le plus *propre* possible !

##Documentation 
La documentation est en cours de rédaction [ici](https://mvc.swith.fr). Vous pouvez vous y référer si vous avez une question sur l'utilisation d'une fonctionnalité. J'avoue avoir rédigé la documentation un peu dans la précipitation, alors si vous remarquez une faute, ou une phrase incompréhensible, vous pouvez me la signaler en ouvrant une issue ou alors par mail.

##Remerciement
Je mentirais si je disais que j'ai tout fait tout seul comme un pro avec 10 ans d'expériences, ce n'est pas le cas ! Tout mes remerciements vont à [Grafikart](http://www.grafikart.fr), ses nombreux tutoriels m'ont beaucoup aidés à en arriver là où j'en suis aujourd'hui. Donc voilà un immense merci à lui !

##TODO
- Un big refacto du code s'impose
- PhpUnit
- Les emails **(minoritaire)**
- ~~Les fonctions de recherche~~ **(DONE)**
- Optimiser le système d'envrionnement **(minoritaire)**
- Checker la sécurité 
- Optimiser les requêtes **(secondaire)**
- Ajout de commandes shell **(minoritaire)** **WIP**
- ~~Refaire le composant Auth~~ **(DONE)**
- ~~S'occuper des erreurs~~ **(DONE)**
- ~~Gérer le cache~~ **(DONE)**
