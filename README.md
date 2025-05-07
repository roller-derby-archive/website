# Roller Derby Archive

## Contribution

### Backend

Le Backend est un symfony 7.2, tournant sous php 8.2

### Frontend

*Pour rappel, je ne suis pas dev frontend de formation.*

Le front utilise le framework js [Hotwire:turbo](https://turbo.hotwired.dev) pour gérer la partie "Réactive" avec une couche de Javasript Vanilla pour les intéractions.

### Integration

*Pour rappel, je ne suis pas intégratrice de formation.*

Site tournant sous symfony "oblige", le html est généré via le moteur de template [Twig](https://twig.symfony.com), le css est généré par [Sass](https://sass-lang.com/). A noter qu'il n'y a pas de library de type boostrap (je trouve ça inutilement lourd).

#### Quelques standards & conventions:

- les class css sont écrite en ```minor-kebab-case```, et sont toujours préfixé par ```rda-``` (accronyme de ```roller derby archive```)
- les id css sont écrit en ```minor_snake_case```, et sont toujours préfixé par ```rda_```
